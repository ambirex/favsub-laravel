<html>
<head>
<script type="text/javascript">	
	function closeIt() {

		self.close();

	}
	
	function doClose() {

		setTimeout("closeIt()", 500);

	}

	</script>
<style>
/* popup page specific */
h1 {height: 29px; padding: 0; margin: 0;}
h1 img {margin: 6px 0 6px 5px;}
h2 {margin: 10px 0 5px 5px; font-size: 110%; line-height:1.5em; padding: 0;}
body {
    background-color: #fff;
        margin: 0; padding: 0;
        color:#333; font-family:Verdana;
        text-align: left;
    line-height:16px;
        font-size: 66%;
}
p {margin: 0 0 5px 5px; padding: 10px 5px 0 0;}

.popupHeader, .popupHeader2 {background-image: url(/i/bg-header-pop.gif);color:white;font-size:21px;font-weight:bold;padding: 8px 0 8px 6px;}
.popupHeader2 {font-size:11px;padding: 8px 6px 8px 0;}
.popupHeader2 a, .popupHeader2 a:visited, .popupHeader2 a:hover{color:white;}

.gray {background-color:#cccecc;}

#popclose {     margin:12px 0 12px 0; border-top: #fc0 1px solid;}

#pinstrip{width:100%;}
.closewindow {text-align: right; font-size: .9em; padding: 0px; margin: 0px; margin-right:10px;}
.bottomBorder {border: 1px solid #FFE56D; border-width:0 0 1px 0;margin-bottom:3px;}
.alignBottom {position: absolute; width: 100%; bottom: 0; right: 0; margin: 0; padding: 0;margin-bottom:3px;}

/* Old Furl Stuff */
.greenBox { border: 1px solid green; padding: 5px; margin-bottom: 10px; }
.greenBox TH {background: #9ACD32; color: white; }

.yellowBox { border: 1px solid #FF6600; padding: 5px; margin-bottom: 10px; }
.yellowBox TH {background: #FFEEAB; color: black; }

.redBox { border: 1px solid red; padding: 5px; margin-bottom: 10px; }
.redBox TH {background: red; color: white; }

/* Code for the topic menu */
.topBand {
        background-color:#d7e3eb;
        padding: 2px 5px;
}

#topicMenu {
        display:block; /* was set to none in main.css for buggy browsers */
        }

#topicLink {
        display:block;
        padding: 0px 20px 0px 0;
        font-weight: bold;
        font-size: 86%;
        color: #000;
        z-index: 10;
        height:1.65em;
        text-decoration:none;
        }

#topicMenu {
        width:380px;
        margin-right: -380px;
        position:relative;
        top:-3px;
        z-index: 10;
        }

#topicMenu div.inactive {
        width:380px;
        visibility: hidden;
        position:absolute;
        }

#topicMenu div.active {
        width:380px;
        height:178px;
        visibility: visible;
        overflow: auto;
        border: 1px solid #000;
        position:absolute;
        background:#fff;
        padding:5px;
        background-color:#f8faff;
        border: 1px solid #E4E4E7;
        border-right:2px outset ;
        border-bottom: 2px outset ;
        /*margin-left: 5px;*/
    margin-left: -50px;
        margin-top: 1.6em;
        }

*html #topicMenu div.active {
        overflow: auto;
}

#topicMenu ul {
        margin:0px;
        list-style-type: none;
        }

#topicMenu h3 {
        margin:0px;
        padding-left: 6px;
        font-size: 89%;
        font-weight:normal;
        text-transform: uppercase;
        }
#topicMenu #topicMCol h3  {
        padding-left: 7px;
        }

#topicArea {
        }

#topicLCol,
#topicMCol,
#topicRCol {
        float:left;
        width:120px;
        }

#topicLCol ul {
    padding: 0px;
        margin: 0px;
}

#topicRCol ul {
    padding: 0px;
        margin: 0px;
}

#topicMenu #topicMCol a, #topicMenu #topicRCol a {
        padding-left:5px;
        }

#topicMenu #topicMCol ul{
        border-right: 1px solid #777;
        border-left: 1px solid #777;
        padding: 0px;
        }

#topicMenu ul {
        margin-bottom:10px;
        }

#topicMenu li {
        font-size:86%;
        margin: 0px;
        padding:0px;
        line-height: 1.6em;
        width: 120px;
        }

*html #topicMenu li {line-height: 1.5em;}

#topicMenu a {
        text-decoration:none;
        padding: .1em 6px .2em 0 ;
        display:inline;
        height: 1.4em;
        }
* html #topicMenu a {
        padding-bottom: 0px;
        }


#topicMenu a:hover {
        background-color: #d7e3eb;
        }

#topicLink {
        width:288px;
        height:17px;
        background-image: url(/i/btn-seeTopics-off.gif);
        background-repeat:no-repeat;
}

a#topicLink.deactivate {
        width:288px;
        height:17px;
        background-image: url(/i/btn-seeTopics-off.gif);
        background-repeat:no-repeat;
}

/*a#topicLink:hover,*/
a#topicLink.active {
        border-bottom: none;
        background-image: url(/i/btn-seeTopics-on.gif);
        background-repeat:no-repeat;
        }

#topicButton {
        width:288px;
}

/* Autocomplete styles */
.AutoCompleteBackground
{
    background-color:#f8faff;
}
.AutoCompleteHighlight
{
    background-color:#d7e3eb;
}

.rowcell {
        display: inline;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100px;
        height: 100%;
        padding: 0px 5px;
        vertical-align: center;
}
</style>
</head>

<body bgcolor="white" onLoad="doClose();">
<table width="100%" height="75%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="center">

<center>

<table width="300" class="greenBox">
<tr><th>Success!</th></tr>
<tr><td align="center">
<span class="success"><b>Bookmark Saved</b></span>
</td></tr>
</table>

</center>
</td></tr>
</table>

</body>
</html>