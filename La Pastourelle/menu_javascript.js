Abgcolor='#ce0000';
Abgcolor0='#E9967A'; 
Abgcolor1='#FF69B4'; 
Abgcolor2='#d1cfcf'; 
Abgcolor3='#9b9b9b';
Abgcolor4='#7a7979'; 
Abgcolor5='#5f5f5f'; 
Abgcolor6='#434343'; 
Abgcolor7='#2a2a2a'; 
Abgcolor8='#000000'; 
Abgcolor9='#ADFF2F';

Azgcolor = new Array;
Azgcolor[0] = '#D1CFCF'; 
Azgcolor[1] = '#5f5f5f'; 
Azgcolor[2] = '#000000'; 
Azgcolor[3] = '#48D1CC'; 
Azgcolor[4] = '#FFA500'; 
Azgcolor[5] = '#BC8F8F'; 
Azgcolor[6] = '#00FF00'; 
Azgcolor[7] = '#FFB6C1'; 
Azgcolor[8] = '#D2691E'; 
Azgcolor[9] = '#ADFF2F'; 

document.write('<style type="text/css">');
document.write('.popper { POSITION: absolute; VISIBILITY: hidden;}')
document.write('#topgauche { position:absolute;  }')
document.write('A:hover.ejsmenu {color:#FFFFFF; text-decoration:none;}')
document.write('A.ejsmenu {color:#FFFFFF; text-decoration:none;}')
document.write('</style>')
document.write('<div style="position:relative;height:25"><DIV class=popper id=topdeck></DIV>');


Azlien = new Array;
Azlien[0] = new Array;
Azlien[1] = new Array;
Azlien[2] = new Array;
Azlien[3] = new Array;
Azlien[4] = new Array;
Azlien[5] = new Array;
Azlien[6] = new Array;
Azlien[1][0] = '<A HREF="#" CLASS=ejsmenu>&nbsp </A>';
Azlien[1][1] = '<A HREF="index.php?page=danse" CLASS=ejsmenu>&nbsp '+menuTrad[8]+'</A>';
Azlien[1][2] = '<A HREF="index.php?page=theatre" CLASS=ejsmenu>&nbsp '+menuTrad[7]+'</A>';
Azlien[1][3] = '<A HREF="index.php?page=ecole" CLASS=ejsmenu>&nbsp '+menuTrad[9]+'</A>';
Azlien[6][0] = '<A HREF="#" CLASS=ejsmenu>&nbsp </A>';
Azlien[6][1] = '<A HREF="index.php?page=coordonnees" CLASS=ejsmenu>&nbsp '+menuTrad[10]+'</A>';
Azlien[6][2] = '<A HREF="index.php?page=avis" CLASS=ejsmenu>&nbsp '+menuTrad[11]+'</A>';

var nava = (document.layers);
var dom = (document.getElementById);
var iex = (document.all);
if (nava) { Askn = document.topdeck }
else if (dom) { Askn = document.getElementById("topdeck").style }
else if (iex) { Askn = topdeck.style }
Askn.top = 24;

function pop(msg,pos)
{
	Askn.visibility = "hidden";
	a=true
	Askn.left = pos;
	var content ="<TABLE BORDER=0 style='position:absolute; margin-left:"+pos+"px;' CELLPADDING=0 CELLSPACING=0 BGCOLOR=#ffffff WIDTH=180><TR><TD><TABLE WIDTH=100% BORDER=0 CELLPADDING=0 CELLSPACING=1>";
	pass = 0
	while (pass < msg.length)
		{
			content += "<TR><TD BGCOLOR="+Abgcolor+" onMouseOver=\"this.style.background='"+Azgcolor[pass-1]+"'\" onMouseOut=\"this.style.background='"+Abgcolor+"'\" HEIGHT=20><FONT SIZE=1 FACE=\"Verdana\">  "+msg[pass]+"</FONT></TD></TR>";
			pass++;
		}
	content += "</TABLE></TD></TR></TABLE>";
	if (nava)
		{
			Askn.document.write(content);
			Askn.document.close();
			Askn.visibility = "visible";
		}
	else if (dom)
			{
				document.getElementById("topdeck").innerHTML = content;
				Askn.visibility = "visible";
			}
		else if (iex)
			{
				document.all("topdeck").innerHTML = content;
				Askn.visibility = "visible";
			}
}

function kill()
{
	Askn.visibility = "hidden";
}

document.onclick = kill;
document.write('<DIV ID=topgauche><TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#ffffff WIDTH=800><TR><TD><TABLE CELLPADING=0 CELLSPACING=1 BORDER=0 WIDTH=100% HEIGHT=23><TR>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor2+'\';pop(Azlien[0],0)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[0],0)" href=# CLASS=ejsmenu><FONT SIZE=1 font-weight="bold" FACE="Verdana"><A HREF="index.php?page=accueil" CLASS=ejsmenu>'+menuTrad[0]+'</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor3+'\';pop(Azlien[1],100)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[1],0)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana">'+menuTrad[1]+'</FONT></a></TD>') 
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor4+'\';pop(Azlien[2],200)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[2],200)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=historique" CLASS=ejsmenu>'+menuTrad[2]+'</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor5+'\';pop(Azlien[3],300)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[3],300)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=boutique" CLASS=ejsmenu>'+menuTrad[3]+'</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor6+'\';pop(Azlien[4],400)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[4],400)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=revuedepresse" CLASS=ejsmenu>'+menuTrad[4]+'</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor7+'\';pop(Azlien[5],500)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[5],500)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana"><A HREF="index.php?page=lien" CLASS=ejsmenu>'+menuTrad[5]+'</A></FONT></a></TD>')
document.write('<TD WIDTH=120 ALIGN=center BGCOLOR='+Abgcolor+' onMouseOver="this.style.background=\''+Abgcolor8+'\';pop(Azlien[6],600)" onMouseOut="this.style.background=\''+Abgcolor+'\'"><A onClick="return(false)" onMouseOver="pop(Azlien[6],600)" href=# CLASS=ejsmenu><FONT SIZE=1 FACE="Verdana">'+menuTrad[6]+'</FONT></a></TD>')
document.write('</TR></TABLE></TD></TR></TABLE></DIV></div>')