<?php


$_config = array();

// ----------------------------  CONFIG DB  ----------------------------- //
$_config['db']['1']['dbhost'] = '127.0.0.1:3306';
$_config['db']['1']['dbuser'] = 'root';
$_config['db']['1']['dbpw'] = '1234';
$_config['db']['1']['dbcharset'] = 'utf8';
$_config['db']['1']['pconnect'] = '0';
$_config['db']['1']['dbname'] = 'pichome_php81_test';
$_config['db']['1']['tablepre'] = 'pichome_';
$_config['db']['1']['port'] = '3306';
$_config['db']['1']['unix_socket'] = '';
$_config['db']['slave'] = '';
$_config['db']['common']['slave_except_table'] = '';

// --------------------------  CONFIG MEMORY  --------------------------- //
$_config['memory']['prefix'] = 'Q2fCTk_';
$_config['memory']['redis']['server'] = '';
$_config['memory']['redis']['port'] = 6379;
$_config['memory']['redis']['pconnect'] = 1;
$_config['memory']['redis']['timeout'] = '0';
$_config['memory']['redis']['requirepass'] = '';
$_config['memory']['redis']['serializer'] = 1;
$_config['memory']['memcache']['server'] = '';
$_config['memory']['memcache']['port'] = 11211;
$_config['memory']['memcache']['pconnect'] = 1;
$_config['memory']['memcache']['timeout'] = 1;
$_config['memory']['memcached']['server'] = '127.0.0.1';
$_config['memory']['memcached']['port'] = 11211;
$_config['memory']['memcached']['pconnect'] = 1;
$_config['memory']['memcached']['timeout'] = 1;
$_config['memory']['apc'] = 1;
$_config['memory']['xcache'] = 1;
$_config['memory']['eaccelerator'] = '0';
$_config['memory']['wincache'] = 1;

// --------------------------  CONFIG SERVER  --------------------------- //
$_config['server']['id'] = 1;

// --------------------------  CONFIG REMOTE  --------------------------- //
$_config['remote']['on'] = '0';
$_config['remote']['cron'] = '0';

// ---------------------------  CONFIG CACHE  --------------------------- //
$_config['cache']['type'] = 'sql';

// --------------------------  CONFIG OUTPUT  --------------------------- //
$_config['output']['charset'] = 'utf-8';
$_config['output']['forceheader'] = 1;
$_config['output']['gzip'] = '0';
$_config['output']['tplrefresh'] = 1;
$_config['output']['language'] = 'zh-CN';
$_config['output']['language_list']['zh-CN'] = '简体中文';
$_config['output']['language_list']['en-US'] = 'English';
$_config['output']['staticurl'] = 'static/';
$_config['output']['ajaxvalidate'] = '0';
$_config['output']['iecompatible'] = '0';

// --------------------------  CONFIG COOKIE  --------------------------- //
$_config['cookie']['cookiepre'] = 'iyCY_';
$_config['cookie']['cookiedomain'] = '';
$_config['cookie']['cookiepath'] = '/';

// -------------------------  CONFIG SECURITY  -------------------------- //
$_config['security']['authkey'] = '8f7d51655e8cb6f9cec1c42dabb308d4yIX3ONIGKbkz1CIiDo';
$_config['security']['urlxssdefend'] = 1;
$_config['security']['attackevasive'] = '0';
$_config['security']['querysafe']['status'] = 1;
$_config['security']['querysafe']['dfunction']['0'] = 'load_file';
$_config['security']['querysafe']['dfunction']['1'] = 'hex';
$_config['security']['querysafe']['dfunction']['2'] = 'substring';
$_config['security']['querysafe']['dfunction']['3'] = 'ord';
$_config['security']['querysafe']['dfunction']['4'] = 'char';
$_config['security']['querysafe']['daction']['0'] = '@';
$_config['security']['querysafe']['daction']['1'] = 'intooutfile';
$_config['security']['querysafe']['daction']['2'] = 'intodumpfile';
$_config['security']['querysafe']['daction']['3'] = 'unionselect';
$_config['security']['querysafe']['daction']['4'] = 'unionall';
$_config['security']['querysafe']['daction']['5'] = 'uniondistinct';
$_config['security']['querysafe']['dnote']['0'] = '/*';
$_config['security']['querysafe']['dnote']['1'] = '*/';
$_config['security']['querysafe']['dnote']['2'] = '#';
$_config['security']['querysafe']['dnote']['3'] = '--';
$_config['security']['querysafe']['dnote']['4'] = '"';
$_config['security']['querysafe']['dlikehex'] = 1;
$_config['security']['querysafe']['afullnote'] = '0';

// --------------------------  CONFIG ADMINCP  -------------------------- //
// -------- Founders: $_config['admincp']['founder'] = '1,2,3'; --------- //
$_config['admincp']['founder'] = '1';
$_config['admincp']['checkip'] = 1;
$_config['admincp']['runquery'] = '0';
$_config['admincp']['dbimport'] = '0';
$_config['admincp']['checksession'] = 1800;

// -------------------------  CONFIG USERLOGIN  ------------------------- //
$_config['userlogin']['checkip'] = 1;
$_config['userlogin']['checksession'] = '0';

// ---------------------  CONFIG PICHOMECLOSESHARE  --------------------- //
$_config['pichomecloseshare'] = '0';

// --------------------  CONFIG PICHOMECLOSECOLLECT  -------------------- //
$_config['pichomeclosecollect'] = '0';

// -------------------  CONFIG PICHOMECLOSEDOWNLOAD  -------------------- //
$_config['pichomeclosedownload'] = '0';

// -------------------  CONFIG PICHOMETHUMSMALLWIDTH  ------------------- //
$_config['pichomethumsmallwidth'] = 360;

// ------------------  CONFIG PICHOMETHUMSMALLHEIGHT  ------------------- //
$_config['pichomethumsmallheight'] = 360;

// -------------------  CONFIG PICHOMETHUMLARGEWIDTH  ------------------- //
$_config['pichomethumlargewidth'] = 1920;

// ------------------  CONFIG PICHOMETHUMLARGEHEIGHT  ------------------- //
$_config['pichomethumlargeheight'] = 1080;

// --------------------  CONFIG GDGETCOLOREXTLIMIT  --------------------- //
$_config['gdgetcolorextlimit'] = 'jpg,png,jpeg,gif';

// -------------------  CONFIG IMAGEICKALLOWEXTLIMIT  ------------------- //
$_config['imageickallowextlimit'] = 'aai,art,arw,avs,bpg,bmp,bmp2,bmp3,brf,cals,cals,cgm,cin,cip,cmyk,cmyka,cr2,crw,cube,cur,cut,dcm,dcr,dcx,dds,dib,djvu,dng,dot,dpx,emf,epdf,epi,eps,eps2,eps3,epsf,epsi,ept,exr,fax,fig,fits,fpx,gplt,gray,graya,hdr,heic,hpgl,hrz,ico,info,isobrl,isobrl6,jbig,jng,jp2,jpt,j2c,j2k,jxr,json,man,mat,miff,mono,mng,m2v,mpc,mpr,mrwmmsl,mtv,mvg,nef,orf,otb,p7,palm,pam,clipboard,pbm,pcd,pcds,pcl,pcx,pdb,pef,pes,pfa,pfb,pfm,pgm,picon,pict,pix,png8,png00,png24,png32,png48,png64,pnm,ppm,ps,ps2,ps3,psb,psd,ptif,pwp,rad,raf,rgb,rgb565,rgba,rgf,rla,rle,sfw,sgi,shtml,sid,mrsid,sum,svg,text,tga,tif,tiff,tim,ttf,ubrl,ubrl6,uil,uyvy,vicar,viff,wbmp,wpg,webp,wmf,wpg,x,xbm,xcf,xpm,xwd,x3f,YCbCr,YCbCrA,yuv,sr2,srf,srw,rw2,nrw,mrw,kdc,erf,canvas,caption,clip,clipboard,fractal,gradient,hald,histogram,inline,map,mask,matte,null,pango,plasma,preview,print,scan,radial_gradient,scanx,screenshot,stegano,tile,unique,vid,win,xc,granite,logo,netscpe,rose,wizard,bricks,checkerboard,circles,crosshatch,crosshatch30,crosshatch45,fishscales,gray0,gray5,gray10,gray15,gray20,gray25,gray30,gray35,gray40,gray45,gray50,gray55,gray60,gray65,gray70,gray75,gray80,gray85,gray90,gray95,gray100,hexagons,horizontal,horizontal2,horizontal3,horizontalsaw,hs_bdiagonal,hs_cross,hs_diagcross,hs_fdiagonal,hs_vertical,left30,left45,leftshingle,octagons,right30,right45,rightshingle,smallfishcales,vertical,vertical2,vertical3,verticalfishingle,vericalrightshingle,verticalleftshingle,verticalsaw,fff,3fr,ai,iiq,cdr';

// -------------------  CONFIG PICHOMESPECIALIMGEXT  -------------------- //
$_config['pichomespecialimgext'] = 'aai,art,arw,avs,bpg,bmp,bmp2,bmp3,brf,cals,cals,cgm,cin,cip,cmyk,cmyka,cr2,crw,cube,cur,cut,dcm,dcr,dcx,dds,dib,djvu,dng,dot,dpx,emf,epdf,epi,eps,eps2,eps3,epsf,epsi,ept,exr,fax,fig,fits,fpx,gplt,gray,graya,hdr,heic,hpgl,hrz,ico,info,isobrl,isobrl6,jbig,jng,jp2,jpt,j2c,j2k,jxr,json,man,mat,miff,mono,mng,m2v,mpc,mpr,mrwmmsl,mtv,mvg,nef,orf,otb,p7,palm,pam,clipboard,pbm,pcd,pcds,pcl,pcx,pdb,pef,pes,pfa,pfb,pfm,pgm,picon,pict,pix,png8,png00,png24,png32,png48,png64,pnm,ppm,ps,ps2,ps3,psb,psd,ptif,pwp,rad,raf,rgb,rgb565,rgba,rgf,rla,rle,sfw,sgi,shtml,sid,mrsid,sum,text,tga,tif,tiff,tim,ttf,ubrl,ubrl6,uil,uyvy,vicar,viff,wbmp,wpg,wmf,wpg,x,xbm,xcf,xpm,xwd,x3f,YCbCr,YCbCrA,yuv,sr2,srf,srw,rw2,nrw,mrw,kdc,erf,canvas,caption,clip,clipboard,fractal,gradient,hald,histogram,inline,map,mask,matte,null,pango,plasma,preview,print,scan,radial_gradient,scanx,screenshot,stegano,tile,unique,vid,win,xc,granite,logo,netscpe,rose,wizard,bricks,checkerboard,circles,crosshatch,crosshatch30,crosshatch45,fishscales,gray0,gray5,gray10,gray15,gray20,gray25,gray30,gray35,gray40,gray45,gray50,gray55,gray60,gray65,gray70,gray75,gray80,gray85,gray90,gray95,gray100,hexagons,horizontal,horizontal2,horizontal3,horizontalsaw,hs_bdiagonal,hs_cross,hs_diagcross,hs_fdiagonal,hs_vertical,left30,left45,leftshingle,octagons,right30,right45,rightshingle,smallfishcales,vertical,vertical2,vertical3,verticalfishingle,vericalrightshingle,verticalleftshingle,verticalsaw,fff,3fr,ai,iiq,cdr';

// --------------------  CONFIG PICHOMECOMMIMAGEEXT  -------------------- //
$_config['pichomecommimageext'] = 'jpg,png,jpeg,gif,svg,webp';

// ------------------  CONFIG ONLYOFFICEVIEWEXTLIMIT  ------------------- //
$_config['onlyofficeviewextlimit'] = 'pdf,doc,docx,rtf,odt,htm,html,mht,txt,ppt,pptx,pps,ppsx,odp,xls,xlsx,ods,csv';

// -------------------------  CONFIG QCOSMEDIA  ------------------------- //
$_config['qcosmedia'] = '3gp,avi,flv,mp4,m3u8,mpg,asf,wmv,mkv,mov,ts,webm,mxf';

// ------------------------  CONFIG QCOSOFFICE  ------------------------- //
$_config['qcosoffice'] = 'pptx,ppt,pot,potx,pps,ppsx,dps,dpt,pptm,potm,ppsm,doc,dot,wps,wpt,docx,dotx,docm,dotm,xls,xlt,et,ett,xlsx,xltx,csv,xlsb,xlsm,xltm,ets,pdf,lrc,c,cpp,h,asm,s,java,asp,bat,bas,prg,cmd,rtf,txt,log,xml,htm,html';

// -------------------------  CONFIG QCOSIMAGE  ------------------------- //
$_config['qcosimage'] = 'jpg,bmp,gif,png,webp';

// -------------------  CONFIG PICHOMEFFMPEGPOSITION  ------------------- //
$_config['pichomeffmpegposition'] = '';

// ------------------  CONFIG PICHOMEFFPROBEPOSITION  ------------------- //
$_config['pichomeffprobeposition'] = '';

// ----------------  CONFIG PICHOMEFFMPEGGETVIEOINFOEXT  ---------------- //
$_config['pichomeffmpeggetvieoinfoext'] = 'avi,rm,rmvb,mkv,mov,wmv,asf,mpg,mpe,mpeg,mp4,m4v,mpeg,f4v,vob,ogv,mts,mt2s,3gp,webm,flv,wav,mp3,ogg,midi,wma,vqf,ra,aac,flac,ape,amr,aiff,au,m4a,mxf';

// -----------------  CONFIG PICHOMEFFMPEGGETTHUMBEXT  ------------------ //
$_config['pichomeffmpeggetthumbext'] = 'avi,rm,rmvb,mkv,mov,wmv,asf,mpg,mpe,mpeg,mp4,m4v,mpeg,f4v,vob,ogv,mts,m2ts,3gp,webm,flv,wav,mp3,ogg,midi,wma,vqf,ra,aac,flac,ape,amr,aiff,au,m4a,mxf';

// ------------------  CONFIG PICHOMEFFMPEGCONVERTEXT  ------------------ //
$_config['pichomeffmpegconvertext'] = 'avi,rm,rmvb,mkv,mov,wmv,asf,mpg,mpeg,f4v,vob,ogv,mts,m2ts,mpe,3gp,midi,wma,vqf,ra,aac,flac,ape,amr,aiff,au,m4a,m4v,mxf';

// -------------------  CONFIG PICHOMEPLAYERMEDIAEXT  ------------------- //
$_config['pichomeplayermediaext'] = 'mp3,mp4,webm,ogv,ogg,wav,m3u8,hls,mpg,mpeg';

// ---------------------  CONFIG PICHOMECONVERTEXT  --------------------- //
$_config['pichomeconvertext'] = 'webm,ogv,ogg,wav,m3u8,hls,mpg,3gp,avi,flv,mp4,asf,wmv,mkv,mov,ts,mxf';

// ----------------------  CONFIG PICHOMEXGPLAYER  ---------------------- //
$_config['pichomexgplayer'] = 'mp3,mp4,flv,webm,ogv,ogg,wav,m3u8,hls,mpg,avi,rm,rmvb,mkv,mov,wmv,asf,mpg,mpeg,f4v,vob,ogv,mts,m2ts,mpe,ogg,3gp,flv,midi,wma,vqf,ra,aac,flac,ape,amr,aiff,au,m4a,m4v';

// -----------------------  CONFIG VIDEOQUALITY  ------------------------ //
$_config['videoquality']['0']['name'] = '流畅';
$_config['videoquality']['0']['width'] = 640;
$_config['videoquality']['0']['height'] = 360;
$_config['videoquality']['0']['bitrate'] = 400;
$_config['videoquality']['1']['name'] = '标清';
$_config['videoquality']['1']['width'] = 960;
$_config['videoquality']['1']['height'] = 510;
$_config['videoquality']['1']['bitrate'] = 900;
$_config['videoquality']['2']['name'] = '高清';
$_config['videoquality']['2']['width'] = 1280;
$_config['videoquality']['2']['height'] = 720;
$_config['videoquality']['2']['bitrate'] = 1500;
$_config['videoquality']['3']['name'] = '超清';
$_config['videoquality']['3']['width'] = 1920;
$_config['videoquality']['3']['height'] = 1080;
$_config['videoquality']['3']['bitrate'] = 3000;
$_config['videoquality']['4']['name'] = '2k';
$_config['videoquality']['4']['width'] = 3500;
$_config['videoquality']['4']['height'] = 2560;
$_config['videoquality']['4']['bitrate'] = 1440;
$_config['videoquality']['5']['name'] = '4k';
$_config['videoquality']['5']['width'] = 3840;
$_config['videoquality']['5']['height'] = 2160;
$_config['videoquality']['5']['bitrate'] = 6000;

// --------------------  CONFIG DEFAULTVIDEOQUALITY  -------------------- //
$_config['defaultvideoquality'] = 1;

// ----------------------  CONFIG THUMBPROCESSNUM  ---------------------- //
$_config['thumbprocessnum'] = 1;

// ----------------------  CONFIG INFOPROCESSNUM  ----------------------- //
$_config['infoprocessnum'] = 1;

// ---------------------  CONFIG CONVERTPROCESSNUM  --------------------- //
$_config['convertprocessnum'] = 1;

// ----------------------  CONFIG IMAGICKTHUMEXT  ----------------------- //
$_config['imagickthumext'] = 'aai,art,arw,avs,bpg,bmp,bmp2,bmp3,brf,cals,cals,cgm,cin,cip,cmyk,cmyka,cr2,crw,cube,cur,cut,dcm,dcr,dcx,dds,dib,djvu,dng,dot,dpx,emf,epdf,epi,eps,eps2,eps3,epsf,epsi,ept,exr,fax,fig,fits,fpx,gplt,gray,graya,hdr,heic,hpgl,hrz,ico,info,isobrl,isobrl6,jbig,jng,jp2,jpt,j2c,j2k,jxr,json,man,mat,miff,mono,mng,m2v,mpc,mpr,mrwmmsl,mtv,mvg,nef,orf,otb,p7,palm,pam,clipboard,pbm,pcd,pcds,pcl,pcx,pdb,pef,pes,pfa,pfb,pfm,pgm,picon,pict,pix,png8,png00,png24,png32,png48,png64,pnm,ppm,ps,ps2,ps3,psb,psd,ptif,pwp,rad,raf,rgb,rgb565,rgba,rgf,rla,rle,sfw,sgi,shtml,sid,mrsid,sum,svg,text,tga,tif,tiff,tim,ttf,ubrl,ubrl6,uil,uyvy,vicar,viff,wbmp,wpg,webp,wmf,wpg,x,xbm,xcf,xpm,xwd,x3f,YCbCr,YCbCrA,yuv,sr2,srf,srw,rw2,nrw,mrw,kdc,erf,canvas,caption,clip,clipboard,fractal,gradient,hald,histogram,inline,map,mask,matte,null,pango,plasma,preview,print,scan,radial_gradient,scanx,screenshot,stegano,tile,unique,vid,win,xc,granite,logo,netscpe,rose,wizard,bricks,checkerboard,circles,crosshatch,crosshatch30,crosshatch45,fishscales,gray0,gray5,gray10,gray15,gray20,gray25,gray30,gray35,gray40,gray45,gray50,gray55,gray60,gray65,gray70,gray75,gray80,gray85,gray90,gray95,gray100,hexagons,horizontal,horizontal2,horizontal3,horizontalsaw,hs_bdiagonal,hs_cross,hs_diagcross,hs_fdiagonal,hs_vertical,left30,left45,leftshingle,octagons,right30,right45,rightshingle,smallfishcales,vertical,vertical2,vertical3,verticalfishingle,vericalrightshingle,verticalleftshingle,verticalsaw,fff,3fr,ai,iiq,cdr';

// ------------------------  CONFIG THUMBURLMOD  ------------------------ //
$_config['thumburlmod'] = '0';

// ----------------------  CONFIG AUDIOTHUMETIME  ----------------------- //
$_config['audiothumetime'] = 5;

// --------------------  CONFIG FILTERFILEBYTABPERM  -------------------- //
$_config['filterFileByTabPerm'] = '0';

// ---------------  CONFIG NOTALLOWDIRECTORYEDITFILENAME  --------------- //
$_config['notallowDirectoryEditFilename'] = 1;


// -------------------  THE END  --------------------
 return $_config;