#breadcrumbs-one{
  background: #eee;
  border-width: 1px;
  border-style: solid;
  border-color: #f5f5f5 #e5e5e5 #ccc;
  overflow: hidden;
  width: 100%;
}

#breadcrumbs-one li{
  float: left;
}

#breadcrumbs-one a{
  padding: .7em 1em .7em 2em;
  float: left;
  text-decoration: none;
  color: #444;
  position: relative;
  text-shadow: 0 1px 0 rgba(255,255,255,.5);
  background-color: #ddd;
  background-image: linear-gradient(to right, #f5f5f5, #ddd);  
}

#breadcrumbs-one li:first-child a{
  padding-left: 1em;
  border-radius: 5px 0 0 5px;
}

#breadcrumbs-one li a {
  background: #fff;
}
#breadcrumbs-one li a::after{
  border-left-color: #fff;
}

#breadcrumbs-one li.active a {
  background: #eee;
}
#breadcrumbs-one li.active a::after{
  border-left-color: #eee;
}

#breadcrumbs-one a:hover{
  background: #fff;
}

#breadcrumbs-one a::after,
#breadcrumbs-one a::before{
  content: "";
  position: absolute;
  top: 50%;
  margin-top: -1.5em;   
  border-top: 1.5em solid transparent;
  border-bottom: 1.5em solid transparent;
  border-left: 1em solid;
  right: -1em;
}

#breadcrumbs-one a::after{ 
  z-index: 2;
  border-left-color: #ddd;  
}

#breadcrumbs-one a::before{
  border-left-color: #ccc;  
  right: -1.1em;
  z-index: 1; 
}

#breadcrumbs-one a:hover::after{
  border-left-color: #fff;
}

#breadcrumbs-one .current,
#breadcrumbs-one .current:hover{
  font-weight: bold;
  background: none;
}

#breadcrumbs-one .current::after,
#breadcrumbs-one .current::before{
  content: normal;  
}

.rating { 
  border: none;
  float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before { 
  content: "\f089";
  position: absolute;
}

.rating > label { 
  color: #ddd; 
 float: right; 
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

.rating > input:checked + label:hover, /* hover current star when changing rating */
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 