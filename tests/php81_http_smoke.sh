#!/usr/bin/env bash
set -euo pipefail

PHPBIN=${PHPBIN:-/opt/homebrew/opt/php@8.1/bin/php}
PORT=${PORT:-18083}
HOST=${HOST:-127.0.0.1}
BASE="http://$HOST:$PORT"
OUT=${OUT:-tests/output/php81_http_smoke.tsv}
LOG=${LOG:-tests/output/php81_http_smoke.server.log}

mkdir -p "$(dirname "$OUT")"
: > "$OUT"

"$PHPBIN" -d display_errors=1 -d html_errors=0 -d error_reporting=E_ALL -S "$HOST:$PORT" -t . >"$LOG" 2>&1 &
SPID=$!
cleanup() {
  kill "$SPID" >/dev/null 2>&1 || true
}
trap cleanup EXIT
sleep 1

endpoints=(
  "/index.php" "/admin.php" "/user.php" "/misc.php?mod=syscache" "/misc/getinfo.php" "/misc/getthumb.php"
  "/misc/getPreviewThumb.php" "/misc/getConvertStatus.php" "/misc/convert.php" "/misc/chkupdatethumb.php"
  "/misc/chkupdatePreviewthumb.php" "/misc/updatepagedata.php" "/misc/dotaskrecord.php" "/misc/exportfilecheck.php"
  "/misc/sendmail.php" "/misc/sendwx.php" "/index.php?mod=manage" "/index.php?mod=systeminfo"
  "/index.php?mod=alonepage" "/index.php?mod=banner" "/index.php?mod=banner&op=admin" "/index.php?mod=pichome"
  "/index.php?mod=pichome&op=library" "/index.php?mod=pichome&op=storagesetting" "/index.php?mod=pichome&op=getConvertStatus"
  "/index.php?mod=search" "/index.php?mod=search&op=setting" "/index.php?mod=io" "/index.php?mod=xgplayer"
  "/index.php?mod=pdf" "/index.php?mod=textviewer" "/index.php?mod=imageColor" "/index.php?mod=onlyoffice_view"
  "/index.php?mod=ffmpeg" "/index.php?mod=qcos" "/admin.php?mod=system" "/admin.php?mod=setting"
  "/admin.php?mod=orguser" "/admin.php?mod=systemlog" "/user.php?mod=space" "/user.php?mod=my" "/user.php?mod=login"
)

check_body() {
  local file="$1"
  if rg -n -i "Fatal error|Parse error|Uncaught|Deprecated|Warning" "$file" >/dev/null 2>&1; then
    echo "ERR"
  else
    echo "OK"
  fi
}

for ep in "${endpoints[@]}"; do
  body=$(mktemp)
  code=$(curl -sS -L -o "$body" -w "%{http_code}" "$BASE$ep" || echo "000")
  mark=$(check_body "$body")
  printf "GET\t%s\t%s\t%s\n" "$code" "$mark" "$ep" >> "$OUT"
  rm -f "$body"
done

body=$(mktemp)
code=$(curl -sS -L -o "$body" -w "%{http_code}" -X POST \
  -d "loginsubmit=1&email=admin&password=invalid&questionid=0&answer=&returnType=json" \
  "$BASE/user.php?mod=login&op=logging" || echo "000")
mark=$(check_body "$body")
printf "POST\t%s\t%s\t%s\n" "$code" "$mark" "/user.php?mod=login&op=logging" >> "$OUT"
rm -f "$body"

body=$(mktemp)
code=$(curl -sS -L -o "$body" -w "%{http_code}" -X POST \
  -d "submit=1&admin_email=admin&admin_password=invalid" \
  "$BASE/admin.php" || echo "000")
mark=$(check_body "$body")
printf "POST\t%s\t%s\t%s\n" "$code" "$mark" "/admin.php" >> "$OUT"
rm -f "$body"

awk -F '\t' 'BEGIN{ok=0;err=0}{if($3=="OK")ok++;else err++}END{print "TOTAL="NR" OK="ok" ERR="err}' "$OUT"
