bgcolor='#ce5700';
bgcolor0='#E9967A'; 
bgcolor1='#FF69B4'; 
bgcolor2='#d1cfcf'; 
bgcolor3='#9b9b9b';
bgcolor4='#7a7979'; 
bgcolor5='#5f5f5f'; 
bgcolor6='#434343'; 
bgcolor7='#2a2a2a'; 
bgcolor8='#000000'; 
//bgcolor9='#ADFF2F';

zgcolor = new Array;
zgcolor[0] = '#D1CFCF'; 
zgcolor[1] = '#5f5f5f'; 
zgcolor[2] = '#000000'; 
zgcolor[3] = '#48D1CC'; 
zgcolor[4] = '#FFA500'; 
zgcolor[5] = '#BC8F8F'; 
zgcolor[6] = '#00FF00'; 
zgcolor[7] = '#FFB6C1'; 
zgcolor[8] = '#D2691E'; 
zgcolor[9] = '#ADFF2F'; 

document.write('<style type="text/css">');
document.write('.popper { POSITION: absolute; VISIBILITY: hidden; z-index:3; }')
document.write('#topgauche { position:absolute; z-index:10; }')
document.write('A:hover.ejsmenu {color:#FFFFFF; text-decoration:none;}')
document.write('A.ejsmenu {color:#FFFFFF; text-decoration:none;}')
document.write('</style>')
document.write('<div style="position:relative;height:25"><DIV class=popper id=topdeck></DIV>');


zlien = new Array;
zlien[0] = new Array;
zlien[1] = new Array;
zlien[2] = new Array;
zlien[3] = new Array;
zlien[4] = new Array;
zlien[5] = new Array;
zlien[6] = new Array;



var nava = (document.layers);
var dom = (document.getElementById);
var iex = (document.all);
if (nava) { skn = document.topdeck }
else if (dom) { skn = document.getElementById("topdeck").style }
else if (iex) { skn = topdeck.style }
skn.top = 24;


document.onclick = kill;
document.write('<DIV ID=topgauche><TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#ffffff WIDTH=800><TR><TD><TABLE CELLPADING=0 CELLSPACING=1 BORDER=0 WIDTH=100% HEIGHT=23><TR>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+bgcolor+' onMouseOver="this.style.background=\''+bgcolor3+'\';pop(zlien[1],100)" onMouseOut="this.style.background=\''+bgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(zlien[1],100)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=blog" CLASS=ejsmenu>BLOG</A></FONT></a></TD>') 
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+bgcolor+' onMouseOver="this.style.background=\''+bgcolor4+'\';pop(zlien[2],200)" onMouseOut="this.style.background=\''+bgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(zlien[2],200)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=planning" CLASS=ejsmenu>PLANNING</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+bgcolor+' onMouseOver="this.style.background=\''+bgcolor5+'\';pop(zlien[3],300)" onMouseOut="this.style.background=\''+bgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(zlien[3],300)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=annuaire" CLASS=ejsmenu>ANNUAIRE</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+bgcolor+' onMouseOver="this.style.background=\''+bgcolor6+'\';pop(zlien[4],400)" onMouseOut="this.style.background=\''+bgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(zlien[4],400)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=compte_rendu" CLASS=ejsmenu>COMPTE RENDU</A></FONT></a></TD>')
document.write('</TR></TABLE></TD></TR></TABLE></DIV></div>')