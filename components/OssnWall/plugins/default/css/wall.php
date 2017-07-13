.ossn-form textarea#post-edit {
    height: 125px;
}
.ossn-wall-post-delete {
    color: #EC2020 !important;
}
.ossn-wall-loading {
    text-align: center;
    padding: 10px;
    width: 100%;
}
.ossn-wall-loading .ossn-loading {
    display: inline-block;
}
#ossn-wall-form .ui-autocomplete-loading {
    background: white url("<?php echo ossn_theme_url();?>images/loading.gif") right center no-repeat;
}
#ossn-wall-form .ui-helper-hidden-accessible {
  	display: none;
}


.file-wrapper {
	display: inline-block; 
	position: relative;
}

.file-row canvas {
    margin-right: 10px;
}

.circle {
	position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
}
.prog-circle .after , .prog-circle{
	background: transparent;
}
.box-file {
    border: 2px dashed #dddfe2;
    border-radius: 2px;
    box-sizing: border-box;
    height: 100px;
    padding-right: 5px;
    position: relative;
    width: 100px;
    cursor: default;
}
.box-file-plus {
    background-image: url("<?php echo ossn_site_url('components/OssnWall/images/plus.png');?>");
    background-position: 50%;
    background-repeat: no-repeat;
    background-size: 20px;

}

.box-file-plus:hover {
    background-image: url("<?php echo ossn_site_url('components/OssnWall/images/plus-hover.png');?>");
    border: 2px dashed #797979;
}

#fileupload {
    cursor: default;
    position: absolute;
    top: 0px;
    right: 0px;
    bottom: 0;
    left: 0;
    font-size: 100px;
    z-index: 2;

    opacity: 0.0; /* Standard: FF gt 1.5, Opera, Safari */
    filter: alpha(opacity=0); /* IE lt 8 */
    -ms-filter: "alpha(opacity=0)"; /* IE 8 */
    -khtml-opacity: 0.0; /* Safari 1.x */
    -moz-opacity: 0.0; /* FF lt 1.5, Netscape */
} 

.upload-remove {
    position: absolute;
    top: 0;
    right: 10px;
}

.files {
    overflow-x: scroll;
    overflow-y: hidden;
    width: 100%;
    white-space: nowrap;
    position: relative;
}

.number-image {
    position: relative;
}

.number-image-background {
    background-color: rgba(0, 0, 0, .4);
    bottom: 0;
    color: #fff;
    font-size: 35px;
    font-weight: normal;
    left: 5px;
    position: absolute;
    right: 5px;
    top: 0;
}
.number-image-table {
    display: table;
    height: 100%;
    width: 100%;
}
.number-image-not-show {
    display: table-cell;
    text-align: center;
    vertical-align: middle
}

.image-item {
    padding-left: 5px;
    padding-right: 5px; 
    background-size: cover; 
    background-position: 
    center center;
    background-clip: content-box;
} 

.image-item-height-300 {
    height: 300px;
}

.image-item-height-150 {
    height: 150px;
}
