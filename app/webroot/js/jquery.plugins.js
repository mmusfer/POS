/*
* jQuery jclock - Clock plugin - v 2.3.0
* http://plugins.jquery.com/project/jclock
*
* Copyright (c) 2007-2009 Doug Sparling <http://www.dougsparling.com>
* Licensed under the MIT License:
* http://www.opensource.org/licenses/mit-license.php
*/
(function($) {
 
  $.fn.jclock = function(options) {
    var version = '2.3.0';
 
    // options
    var opts = $.extend({}, $.fn.jclock.defaults, options);
         
    return this.each(function() {
      $this = $(this);
      $this.timerID = null;
      $this.running = false;
 
      // Record keeping for seeded clock
      $this.increment = 0;
      $this.lastCalled = new Date().getTime();
 
      var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
 
      $this.format = o.format;
      $this.utc = o.utc;
      // deprecate utc_offset (v 2.2.0)
      $this.utcOffset = (o.utc_offset != null) ? o.utc_offset : o.utcOffset;
      $this.seedTime = o.seedTime;
      $this.timeout = o.timeout;
 
      $this.css({
        fontFamily: o.fontFamily,
        fontSize: o.fontSize,
        backgroundColor: o.background,
        color: o.foreground
      });
 
      // %a
      $this.daysAbbrvNames = new Array(7);
      $this.daysAbbrvNames[0] = "Sun";
      $this.daysAbbrvNames[1] = "Mon";
      $this.daysAbbrvNames[2] = "Tue";
      $this.daysAbbrvNames[3] = "Wed";
      $this.daysAbbrvNames[4] = "Thu";
      $this.daysAbbrvNames[5] = "Fri";
      $this.daysAbbrvNames[6] = "Sat";
 
      // %A
      $this.daysFullNames = new Array(7);
      $this.daysFullNames[0] = "Sunday";
      $this.daysFullNames[1] = "Monday";
      $this.daysFullNames[2] = "Tuesday";
      $this.daysFullNames[3] = "Wednesday";
      $this.daysFullNames[4] = "Thursday";
      $this.daysFullNames[5] = "Friday";
      $this.daysFullNames[6] = "Saturday";
 
      // %b
      $this.monthsAbbrvNames = new Array(12);
      $this.monthsAbbrvNames[0] = "Jan";
      $this.monthsAbbrvNames[1] = "Feb";
      $this.monthsAbbrvNames[2] = "Mar";
      $this.monthsAbbrvNames[3] = "Apr";
      $this.monthsAbbrvNames[4] = "May";
      $this.monthsAbbrvNames[5] = "Jun";
      $this.monthsAbbrvNames[6] = "Jul";
      $this.monthsAbbrvNames[7] = "Aug";
      $this.monthsAbbrvNames[8] = "Sep";
      $this.monthsAbbrvNames[9] = "Oct";
      $this.monthsAbbrvNames[10] = "Nov";
      $this.monthsAbbrvNames[11] = "Dec";
 
      // %B
      $this.monthsFullNames = new Array(12);
      $this.monthsFullNames[0] = "January";
      $this.monthsFullNames[1] = "February";
      $this.monthsFullNames[2] = "March";
      $this.monthsFullNames[3] = "April";
      $this.monthsFullNames[4] = "May";
      $this.monthsFullNames[5] = "June";
      $this.monthsFullNames[6] = "July";
      $this.monthsFullNames[7] = "August";
      $this.monthsFullNames[8] = "September";
      $this.monthsFullNames[9] = "October";
      $this.monthsFullNames[10] = "November";
      $this.monthsFullNames[11] = "December";
 
      $.fn.jclock.startClock($this);
 
    });
  };
       
  $.fn.jclock.startClock = function(el) {
    $.fn.jclock.stopClock(el);
    $.fn.jclock.displayTime(el);
  }
 
  $.fn.jclock.stopClock = function(el) {
    if(el.running) {
      clearTimeout(el.timerID);
    }
    el.running = false;
  }
 
  $.fn.jclock.displayTime = function(el) {
    var time = $.fn.jclock.getTime(el);
    el.html(time);
    el.timerID = setTimeout(function(){$.fn.jclock.displayTime(el)},el.timeout);
  }
 
  $.fn.jclock.getTime = function(el) {
    if(typeof(el.seedTime) == 'undefined') {
      // Seed time not being used, use current time
      var now = new Date();
    } else {
      // Otherwise, use seed time with increment
      el.increment += new Date().getTime() - el.lastCalled;
      var now = new Date(el.seedTime + el.increment);
      el.lastCalled = new Date().getTime();
    }
 
    if(el.utc == true) {
      var localTime = now.getTime();
      var localOffset = now.getTimezoneOffset() * 60000;
      var utc = localTime + localOffset;
      var utcTime = utc + (3600000 * el.utcOffset);
      now = new Date(utcTime);
    }
 
    var timeNow = "";
    var i = 0;
    var index = 0;
    while ((index = el.format.indexOf("%", i)) != -1) {
      timeNow += el.format.substring(i, index);
      index++;
 
      // modifier flag
      //switch (el.format.charAt(index++)) {
      //}
      
      var property = $.fn.jclock.getProperty(now, el, el.format.charAt(index));
      index++;
      
      //switch (switchCase) {
      //}
 
      timeNow += property;
      i = index
    }
 
    timeNow += el.format.substring(i);
    return timeNow;
  };
 
  $.fn.jclock.getProperty = function(dateObject, el, property) {
 
    switch (property) {
      case "a": // abbrv day names
          return (el.daysAbbrvNames[dateObject.getDay()]);
      case "A": // full day names
          return (el.daysFullNames[dateObject.getDay()]);
      case "b": // abbrv month names
          return (el.monthsAbbrvNames[dateObject.getMonth()]);
      case "B": // full month names
          return (el.monthsFullNames[dateObject.getMonth()]);
      case "d": // day 01-31
          return ((dateObject.getDate() < 10) ? "0" : "") + dateObject.getDate();
      case "H": // hour as a decimal number using a 24-hour clock (range 00 to 23)
          return ((dateObject.getHours() < 10) ? "0" : "") + dateObject.getHours();
      case "I": // hour as a decimal number using a 12-hour clock (range 01 to 12)
          var hours = (dateObject.getHours() % 12 || 12);
          return ((hours < 10) ? "0" : "") + hours;
      case "m": // month number
          return (((dateObject.getMonth() + 1) < 10) ? "0" : "") + (dateObject.getMonth() + 1);
      case "M": // minute as a decimal number
          return ((dateObject.getMinutes() < 10) ? "0" : "") + dateObject.getMinutes();
      case "p": // either `am' or `pm' according to the given time value,
          // or the corresponding strings for the current locale
          return (dateObject.getHours() < 12 ? "am" : "pm");
      case "P": // either `AM' or `PM' according to the given time value,
          return (dateObject.getHours() < 12 ? "AM" : "PM");
      case "S": // second as a decimal number
          return ((dateObject.getSeconds() < 10) ? "0" : "") + dateObject.getSeconds();
      case "y": // two-digit year
          return dateObject.getFullYear().toString().substring(2);
      case "Y": // full year
          return (dateObject.getFullYear());
      case "%":
          return "%";
    }
 
  }
       
  // plugin defaults (24-hour)
  $.fn.jclock.defaults = {
    format: '%H:%M:%S',
    utcOffset: 0,
    utc: false,
    fontFamily: '',
    fontSize: '',
    foreground: '',
    background: '',
    seedTime: undefined,
    timeout: 1000 // 1000 = one second, 60000 = one minute
  };
 
})(jQuery);
jQuery(function($){var userAgent=navigator.userAgent.toLowerCase();var browserVersion=(userAgent.match(/.+(?:rv|webkit|khtml|opera|msie)[\/: ]([\d.]+)/)||[0,'0'])[1];var isIE6=(/msie/.test(userAgent)&&!/opera/.test(userAgent)&&parseInt(browserVersion)<7&&(!window.XMLHttpRequest||typeof(XMLHttpRequest)==='function'));var body=$('body');var currentSettings;var callingSettings;var shouldResize=false;var gallery={};var fixFF=false;var contentElt;var contentEltLast;var modal={started:false,ready:false,dataReady:false,anim:false,animContent:false,loadingShown:false,transition:false,resizing:false,closing:false,error:false,blocker:null,blockerVars:null,full:null,bg:null,loading:null,tmp:null,content:null,wrapper:null,contentWrapper:null,scripts:new Array(),scriptsShown:new Array()};var resized={width:false,height:false,windowResizing:false};var initSettingsSize={width:null,height:null,windowResizing:true};var windowResizeTimeout;$.fn.nyroModal=function(settings){if(!this)return false;return this.each(function(){var me=$(this);if(this.nodeName.toLowerCase()=='form'){me.unbind('submit.nyroModal').bind('submit.nyroModal',function(e){if(e.isDefaultPrevented())return false;if(me.data('nyroModalprocessing'))return true;if(this.enctype=='multipart/form-data'){processModal($.extend(settings,{from:this}));return true}e.preventDefault();processModal($.extend(settings,{from:this}));return false})}else{me.unbind('click.nyroModal').bind('click.nyroModal',function(e){if(e.isDefaultPrevented())return false;e.preventDefault();processModal($.extend(settings,{from:this}));return false})}})};$.fn.nyroModalManual=function(settings){if(!this.length)processModal(settings);return this.each(function(){processModal($.extend(settings,{from:this}))})};$.nyroModalManual=function(settings){processModal(settings)};$.nyroModalSettings=function(settings,deep1,deep2){setCurrentSettings(settings,deep1,deep2);if(!deep1&&modal.started){if(modal.bg&&settings.bgColor)currentSettings.updateBgColor(modal,currentSettings,function(){});if(modal.contentWrapper&&settings.title)setTitle();if(!modal.error&&(settings.windowResizing||(!modal.resizing&&(('width'in settings&&settings.width==currentSettings.width)||('height'in settings&&settings.height==currentSettings.height))))){modal.resizing=true;if(modal.contentWrapper)calculateSize(true);if(modal.contentWrapper&&modal.contentWrapper.is(':visible')&&!modal.animContent){if(fixFF)modal.content.css({position:''});currentSettings.resize(modal,currentSettings,function(){currentSettings.windowResizing=false;modal.resizing=false;if(fixFF)modal.content.css({position:'fixed'});if($.isFunction(currentSettings.endResize))currentSettings.endResize(modal,currentSettings)})}}}};$.nyroModalRemove=function(){removeModal()};$.nyroModalNext=function(){var link=getGalleryLink(1);if(link)return link.nyroModalManual(getCurrentSettingsNew());return false};$.nyroModalPrev=function(){var link=getGalleryLink(-1);if(link)return link.nyroModalManual(getCurrentSettingsNew());return false};$.fn.nyroModal.settings={debug:false,blocker:false,windowResize:true,modal:false,type:'',forceType:null,from:'',hash:'',processHandler:null,selIndicator:'nyroModalSel',formIndicator:'nyroModal',content:null,bgColor:'#000000',ajax:{},swf:{wmode:'transparent'},width:null,height:null,minWidth:400,minHeight:300,resizable:true,autoSizable:true,padding:25,regexImg:'[^\.]\.(jpg|jpeg|png|tiff|gif|bmp)\s*$',addImageDivTitle:false,defaultImgAlt:'Image',setWidthImgTitle:true,ltr:true,gallery:null,galleryLinks:'<a href="#" class="nyroModalPrev">Prev</a><a href="#"  class="nyroModalNext">Next</a>',galleryCounts:galleryCounts,galleryLoop:false,zIndexStart:100,cssOpt:{bg:{position:'absolute',overflow:'hidden',top:0,left:0,height:'100%',width:'100%'},wrapper:{position:'absolute',top:'50%',left:'50%'},wrapper2:{},content:{},loading:{position:'absolute',top:'50%',left:'50%',marginTop:'-50px',marginLeft:'-50px'}},wrap:{div:'<div class="wrapper"></div>',ajax:'<div class="wrapper"></div>',form:'<div class="wrapper"></div>',formData:'<div class="wrapper"></div>',image:'<div class="wrapperImg"></div>',swf:'<div class="wrapperSwf"></div>',iframe:'<div class="wrapperIframe"></div>',iframeForm:'<div class="wrapperIframe"></div>',manual:'<div class="wrapper"></div>'},closeButton:'<a href="#" class="nyroModalClose" id="closeBut" title="close">Close</a>',title:null,titleFromIframe:true,openSelector:'.nyroModal',closeSelector:'.nyroModalClose',contentLoading:'<a href="#" class="nyroModalClose">Cancel</a>',errorClass:'error',contentError:'The requested content cannot be loaded.<br />Please try again later.<br /><a href="#" class="nyroModalClose">Close</a>',handleError:null,showBackground:showBackground,hideBackground:hideBackground,endFillContent:null,showContent:showContent,endShowContent:null,beforeHideContent:null,hideContent:hideContent,showTransition:showTransition,hideTransition:hideTransition,showLoading:showLoading,hideLoading:hideLoading,resize:resize,endResize:null,updateBgColor:updateBgColor,endRemove:null};function processModal(settings){if(modal.loadingShown||modal.transition||modal.anim)return;debug('processModal');modal.started=true;callingSettings=$.extend(true,settings);setDefaultCurrentSettings(settings);if(!modal.full)modal.blockerVars=modal.blocker=null;modal.error=false;modal.closing=false;modal.dataReady=false;modal.scripts=new Array();modal.scriptsShown=new Array();currentSettings.type=fileType();if(currentSettings.forceType){if(!currentSettings.content)currentSettings.from=true;currentSettings.type=currentSettings.forceType;currentSettings.forceType=null}if($.isFunction(currentSettings.processHandler))currentSettings.processHandler(currentSettings);var from=currentSettings.from;var url=currentSettings.url;initSettingsSize.width=currentSettings.width;initSettingsSize.height=currentSettings.height;if(currentSettings.type=='swf'){setCurrentSettings({overflow:'visible'},'cssOpt','content');currentSettings.content='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+currentSettings.width+'" height="'+currentSettings.height+'"><param name="movie" value="'+url+'"></param>';var tmp='';$.each(currentSettings.swf,function(name,val){currentSettings.content+='<param name="'+name+'" value="'+val+'"></param>';tmp+=' '+name+'="'+val+'"'});currentSettings.content+='<embed src="'+url+'" type="application/x-shockwave-flash" width="'+currentSettings.width+'" height="'+currentSettings.height+'"'+tmp+'></embed></object>'}if(from){var jFrom=$(from).blur();if(currentSettings.type=='form'){var data=$(from).serializeArray();data.push({name:currentSettings.formIndicator,value:1});if(currentSettings.selector)data.push({name:currentSettings.selIndicator,value:currentSettings.selector.substring(1)});showModal();$.ajax($.extend({},currentSettings.ajax,{url:url,data:data,type:jFrom.attr('method')?jFrom.attr('method'):'get',success:ajaxLoaded,error:loadingError}));debug('Form Ajax Load: '+jFrom.attr('action'))}else if(currentSettings.type=='formData'){initModal();jFrom.attr('target','nyroModalIframe');jFrom.attr('action',url);jFrom.prepend('<input type="hidden" name="'+currentSettings.formIndicator+'" value="1" />');if(currentSettings.selector)jFrom.prepend('<input type="hidden" name="'+currentSettings.selIndicator+'" value="'+currentSettings.selector.substring(1)+'" />');modal.tmp.html('<iframe frameborder="0" hspace="0" name="nyroModalIframe" src="javascript:\'\';"></iframe>');$('iframe',modal.tmp).css({width:currentSettings.width,height:currentSettings.height}).error(loadingError).load(formDataLoaded);debug('Form Data Load: '+jFrom.attr('action'));showModal();showContentOrLoading()}else if(currentSettings.type=='image'){debug('Image Load: '+url);var title=jFrom.attr('title')||currentSettings.defaultImgAlt;initModal();modal.tmp.html('<img id="nyroModalImg" />').find('img').attr('alt',title);modal.tmp.css({lineHeight:0});$('img',modal.tmp).error(loadingError).load(function(){debug('Image Loaded: '+this.src);$(this).unbind('load');var w=modal.tmp.width();var h=modal.tmp.height();modal.tmp.css({lineHeight:''});resized.width=w;resized.height=h;setCurrentSettings({width:w,height:h,imgWidth:w,imgHeight:h});initSettingsSize.width=w;initSettingsSize.height=h;setCurrentSettings({overflow:'visible'},'cssOpt','content');modal.dataReady=true;if(modal.loadingShown||modal.transition)showContentOrLoading()}).attr('src',url);showModal()}else if(currentSettings.type=='iframeForm'){initModal();modal.tmp.html('<iframe frameborder="0" hspace="0" src="javascript:\'\';" name="nyroModalIframe" id="nyroModalIframe"></iframe>');debug('Iframe Form Load: '+url);$('iframe',modal.tmp).eq(0).css({width:'100%',height:$.support.boxModel?'99%':'100%'}).load(iframeLoaded);modal.dataReady=true;showModal()}else if(currentSettings.type=='iframe'){initModal();modal.tmp.html('<iframe frameborder="0" hspace="0" src="javascript:\'\';" name="nyroModalIframe" id="nyroModalIframe"></iframe>');debug('Iframe Load: '+url);$('iframe',modal.tmp).eq(0).css({width:'100%',height:$.support.boxModel?'99%':'100%'}).load(iframeLoaded);modal.dataReady=true;showModal()}else if(currentSettings.type){debug('Content: '+currentSettings.type);initModal();modal.tmp.html(currentSettings.content);var w=modal.tmp.width();var h=modal.tmp.height();var div=$(currentSettings.type);if(div.length){setCurrentSettings({type:'div'});w=div.width();h=div.height();if(contentElt)contentEltLast=contentElt;contentElt=div;modal.tmp.append(div.contents())}initSettingsSize.width=w;initSettingsSize.height=h;setCurrentSettings({width:w,height:h});if(modal.tmp.html())modal.dataReady=true;else loadingError();if(!modal.ready)showModal();else endHideContent()}else{debug('Ajax Load: '+url);setCurrentSettings({type:'ajax'});var data=currentSettings.ajax.data||{};if(currentSettings.selector){if(typeof data=="string"){data+='&'+currentSettings.selIndicator+'='+currentSettings.selector.substring(1)}else{data[currentSettings.selIndicator]=currentSettings.selector.substring(1)}}showModal();$.ajax($.extend(true,currentSettings.ajax,{url:url,success:ajaxLoaded,error:loadingError,data:data}))}}else if(currentSettings.content){debug('Content: '+currentSettings.type);setCurrentSettings({type:'manual'});initModal();modal.tmp.html($('<div/>').html(currentSettings.content).contents());if(modal.tmp.html())modal.dataReady=true;else loadingError();showModal()}else{}}function setDefaultCurrentSettings(settings){debug('setDefaultCurrentSettings');currentSettings=$.extend(true,{},$.fn.nyroModal.settings,settings);setMargin()}function setCurrentSettings(settings,deep1,deep2){if(modal.started){if(deep1&&deep2){$.extend(true,currentSettings[deep1][deep2],settings)}else if(deep1){$.extend(true,currentSettings[deep1],settings)}else{if(modal.animContent){if('width'in settings){if(!modal.resizing){settings.setWidth=settings.width;shouldResize=true}delete settings['width']}if('height'in settings){if(!modal.resizing){settings.setHeight=settings.height;shouldResize=true}delete settings['height']}}$.extend(true,currentSettings,settings)}}else{if(deep1&&deep2){$.extend(true,$.fn.nyroModal.settings[deep1][deep2],settings)}else if(deep1){$.extend(true,$.fn.nyroModal.settings[deep1],settings)}else{$.extend(true,$.fn.nyroModal.settings,settings)}}}function setMarginScroll(){if(isIE6&&!modal.blocker){if(document.documentElement){currentSettings.marginScrollLeft=document.documentElement.scrollLeft;currentSettings.marginScrollTop=document.documentElement.scrollTop}else{currentSettings.marginScrollLeft=document.body.scrollLeft;currentSettings.marginScrollTop=document.body.scrollTop}}else{currentSettings.marginScrollLeft=0;currentSettings.marginScrollTop=0}}function setMargin(){setMarginScroll();currentSettings.marginLeft=-(currentSettings.width+currentSettings.borderW)/2;currentSettings.marginTop=-(currentSettings.height+currentSettings.borderH)/2;if(!modal.blocker){currentSettings.marginLeft+=currentSettings.marginScrollLeft;currentSettings.marginTop+=currentSettings.marginScrollTop}}function setMarginLoading(){setMarginScroll();var outer=getOuter(modal.loading);currentSettings.marginTopLoading=-(modal.loading.height()+outer.h.border+outer.h.padding)/2;currentSettings.marginLeftLoading=-(modal.loading.width()+outer.w.border+outer.w.padding)/2;if(!modal.blocker){currentSettings.marginLeftLoading+=currentSettings.marginScrollLeft;currentSettings.marginTopLoading+=currentSettings.marginScrollTop}}function setTitle(){var title=$('h1#nyroModalTitle',modal.contentWrapper);if(title.length)title.text(currentSettings.title);else modal.contentWrapper.prepend('<h1 id="nyroModalTitle">'+currentSettings.title+'</h1>')}function initModal(){debug('initModal');if(!modal.full){if(currentSettings.debug)setCurrentSettings({color:'white'},'cssOpt','bg');var full={zIndex:currentSettings.zIndexStart,position:'fixed',top:0,left:0,width:'100%',height:'100%'};var contain=body;var iframeHideIE='';if(currentSettings.blocker){modal.blocker=contain=$(currentSettings.blocker);var pos=modal.blocker.offset();var w=modal.blocker.outerWidth();var h=modal.blocker.outerHeight();if(isIE6){setCurrentSettings({height:'100%',width:'100%',top:0,left:0},'cssOpt','bg')}modal.blockerVars={top:pos.top,left:pos.left,width:w,height:h};var plusTop=(/msie/.test(userAgent)?0:getCurCSS(body.get(0),'borderTopWidth'));var plusLeft=(/msie/.test(userAgent)?0:getCurCSS(body.get(0),'borderLeftWidth'));full={position:'absolute',top:pos.top+plusTop,left:pos.left+plusLeft,width:w,height:h}}else if(isIE6){body.css({marginLeft:0,marginRight:0});var w=body.width();var h=$(window).height()+'px';if($(window).height()>=body.outerHeight()){h=body.outerHeight()+'px'}else w+=20;w+='px';body.css({width:w,height:h,position:'static',overflow:'hidden'});$('html').css({overflow:'hidden'});setCurrentSettings({cssOpt:{bg:{position:'absolute',zIndex:currentSettings.zIndexStart+1,height:'110%',width:'110%',top:currentSettings.marginScrollTop+'px',left:currentSettings.marginScrollLeft+'px'},wrapper:{zIndex:currentSettings.zIndexStart+2},loading:{zIndex:currentSettings.zIndexStart+3}}});iframeHideIE=$('<iframe id="nyroModalIframeHideIe" src="javascript:\'\';"></iframe>').css($.extend({},currentSettings.cssOpt.bg,{opacity:0,zIndex:50,border:'none'}))}contain.append($('<div id="nyroModalFull"><div id="nyroModalBg"></div><div id="nyroModalWrapper"><div id="nyroModalContent"></div></div><div id="nyrModalTmp"></div><div id="nyroModalLoading"></div></div>').hide());modal.full=$('#nyroModalFull').css(full).show();modal.bg=$('#nyroModalBg').css($.extend({backgroundColor:currentSettings.bgColor},currentSettings.cssOpt.bg)).before(iframeHideIE);modal.bg.bind('click.nyroModal',clickBg);modal.loading=$('#nyroModalLoading').css(currentSettings.cssOpt.loading).hide();modal.contentWrapper=$('#nyroModalWrapper').css(currentSettings.cssOpt.wrapper).hide();modal.content=$('#nyroModalContent');modal.tmp=$('#nyrModalTmp').hide();if($.isFunction($.fn.mousewheel)){modal.content.mousewheel(function(e,d){var elt=modal.content.get(0);if((d>0&&elt.scrollTop==0)||(d<0&&elt.scrollHeight-elt.scrollTop==elt.clientHeight)){e.preventDefault();e.stopPropagation()}})}$(document).bind('keydown.nyroModal',keyHandler);modal.content.css({width:'auto',height:'auto'});modal.contentWrapper.css({width:'auto',height:'auto'});if(!currentSettings.blocker&&currentSettings.windowResize){$(window).bind('resize.nyroModal',function(){window.clearTimeout(windowResizeTimeout);windowResizeTimeout=window.setTimeout(windowResizeHandler,200)})}}}function windowResizeHandler(){$.nyroModalSettings(initSettingsSize)}function showModal(){debug('showModal');if(!modal.ready){initModal();modal.anim=true;currentSettings.showBackground(modal,currentSettings,endBackground)}else{modal.anim=true;modal.transition=true;currentSettings.showTransition(modal,currentSettings,function(){endHideContent();modal.anim=false;showContentOrLoading()})}}function clickBg(e){if(!currentSettings.modal)removeModal()}function keyHandler(e){if(e.keyCode==27){if(!currentSettings.modal)removeModal()}else if(currentSettings.gallery&&modal.ready&&modal.dataReady&&!modal.anim&&!modal.transition){if(e.keyCode==39||e.keyCode==40){e.preventDefault();$.nyroModalNext();return false}else if(e.keyCode==37||e.keyCode==38){e.preventDefault();$.nyroModalPrev();return false}}}function fileType(){var from=currentSettings.from;var url;if(from&&from.nodeName){var jFrom=$(from);url=jFrom.attr(from.nodeName.toLowerCase()=='form'?'action':'href');if(!url)url=location.href.substring(window.location.host.length+7);currentSettings.url=url;if(jFrom.attr('rev')=='modal')currentSettings.modal=true;currentSettings.title=jFrom.attr('title');if(from&&from.rel&&from.rel.toLowerCase()!='nofollow'){var indexSpace=from.rel.indexOf(' ');currentSettings.gallery=indexSpace>0?from.rel.substr(0,indexSpace):from.rel}var imgType=imageType(url,from);if(imgType)return imgType;if(isSwf(url))return'swf';var iframe=false;if(from.target&&from.target.toLowerCase()=='_blank'||(from.hostname&&from.hostname.replace(/:\d*$/,'')!=window.location.hostname.replace(/:\d*$/,''))){iframe=true}if(from.nodeName.toLowerCase()=='form'){if(iframe)return'iframeForm';setCurrentSettings(extractUrlSel(url));if(jFrom.attr('enctype')=='multipart/form-data')return'formData';return'form'}if(iframe)return'iframe'}else{url=currentSettings.url;if(!currentSettings.content)currentSettings.from=true;if(!url)return null;if(isSwf(url))return'swf';var reg1=new RegExp("^http://|https://","g");if(url.match(reg1))return'iframe'}var imgType=imageType(url,from);if(imgType)return imgType;var tmp=extractUrlSel(url);setCurrentSettings(tmp);if(!tmp.url)return tmp.selector}function imageType(url,from){var image=new RegExp(currentSettings.regexImg,'i');if(image.test(url)){return'image'}}function isSwf(url){var swf=new RegExp('[^\.]\.(swf)\s*$','i');return swf.test(url)}function extractUrlSel(url){var ret={url:null,selector:null};if(url){var hash=getHash(url);var hashLoc=getHash(window.location.href);var curLoc=window.location.href.substring(0,window.location.href.length-hashLoc.length);var req=url.substring(0,url.length-hash.length);if(req==curLoc||req==$('base').attr('href')){ret.selector=hash}else{ret.url=req;ret.selector=hash}}return ret}function loadingError(){debug('loadingError');modal.error=true;if(!modal.ready)return;if($.isFunction(currentSettings.handleError))currentSettings.handleError(modal,currentSettings);modal.loading.addClass(currentSettings.errorClass).html(currentSettings.contentError);$(currentSettings.closeSelector,modal.loading).unbind('click.nyroModal').bind('click.nyroModal',removeModal);setMarginLoading();modal.loading.css({marginTop:currentSettings.marginTopLoading+'px',marginLeft:currentSettings.marginLeftLoading+'px'})}function fillContent(){debug('fillContent');if(!modal.tmp.html())return;modal.content.html(modal.tmp.contents());modal.tmp.empty();wrapContent();if(currentSettings.type=='iframeForm'){$(currentSettings.from).attr('target','nyroModalIframe').data('nyroModalprocessing',1).submit().attr('target','_blank').removeData('nyroModalprocessing')}if(!currentSettings.modal)modal.wrapper.prepend(currentSettings.closeButton);if($.isFunction(currentSettings.endFillContent))currentSettings.endFillContent(modal,currentSettings);modal.content.append(modal.scripts);$(currentSettings.closeSelector,modal.contentWrapper).unbind('click.nyroModal').bind('click.nyroModal',removeModal);$(currentSettings.openSelector,modal.contentWrapper).nyroModal(getCurrentSettingsNew())}function getCurrentSettingsNew(){return callingSettings;var currentSettingsNew=$.extend(true,{},currentSettings);if(resized.width)currentSettingsNew.width=null;else currentSettingsNew.width=initSettingsSize.width;if(resized.height)currentSettingsNew.height=null;else currentSettingsNew.height=initSettingsSize.height;currentSettingsNew.cssOpt.content.overflow='auto';return currentSettingsNew}function wrapContent(){debug('wrapContent');var wrap=$(currentSettings.wrap[currentSettings.type]);modal.content.append(wrap.children().remove());modal.contentWrapper.wrapInner(wrap);if(currentSettings.gallery){modal.content.append(currentSettings.galleryLinks);gallery.links=$('[rel="'+currentSettings.gallery+'"], [rel^="'+currentSettings.gallery+' "]');gallery.index=gallery.links.index(currentSettings.from);if(currentSettings.galleryCounts&&$.isFunction(currentSettings.galleryCounts))currentSettings.galleryCounts(gallery.index+1,gallery.links.length,modal,currentSettings);var currentSettingsNew=getCurrentSettingsNew();var linkPrev=getGalleryLink(-1);if(linkPrev){var prev=$('.nyroModalPrev',modal.contentWrapper).attr('href',linkPrev.attr('href')).click(function(e){e.preventDefault();$.nyroModalPrev();return false});if(isIE6&&currentSettings.type=='swf'){prev.before($('<iframe id="nyroModalIframeHideIeGalleryPrev" src="javascript:\'\';"></iframe>').css({position:prev.css('position'),top:prev.css('top'),left:prev.css('left'),width:prev.width(),height:prev.height(),opacity:0,border:'none'}))}}else{$('.nyroModalPrev',modal.contentWrapper).remove()}var linkNext=getGalleryLink(1);if(linkNext){var next=$('.nyroModalNext',modal.contentWrapper).attr('href',linkNext.attr('href')).click(function(e){e.preventDefault();$.nyroModalNext();return false});if(isIE6&&currentSettings.type=='swf'){next.before($('<iframe id="nyroModalIframeHideIeGalleryNext" src="javascript:\'\';"></iframe>').css($.extend({},{position:next.css('position'),top:next.css('top'),left:next.css('left'),width:next.width(),height:next.height(),opacity:0,border:'none'})))}}else{$('.nyroModalNext',modal.contentWrapper).remove()}}calculateSize()}function getGalleryLink(dir){if(currentSettings.gallery){if(!currentSettings.ltr)dir*=-1;var index=gallery.index+dir;if(index>=0&&index<gallery.links.length)return gallery.links.eq(index);else if(currentSettings.galleryLoop){if(index<0)return gallery.links.eq(gallery.links.length-1);else return gallery.links.eq(0)}}return false}function calculateSize(resizing){debug('calculateSize');modal.wrapper=modal.contentWrapper.children('div:first');resized.width=false;resized.height=false;if(false&&!currentSettings.windowResizing){initSettingsSize.width=currentSettings.width;initSettingsSize.height=currentSettings.height}if(currentSettings.autoSizable&&(!currentSettings.width||!currentSettings.height)){modal.contentWrapper.css({opacity:0,width:'auto',height:'auto'}).show();var tmp={width:'auto',height:'auto'};if(currentSettings.width){tmp.width=currentSettings.width}else if(currentSettings.type=='iframe'){tmp.width=currentSettings.minWidth}if(currentSettings.height){tmp.height=currentSettings.height}else if(currentSettings.type=='iframe'){tmp.height=currentSettings.minHeight}modal.content.css(tmp);if(!currentSettings.width){currentSettings.width=modal.content.outerWidth(true);resized.width=true}if(!currentSettings.height){currentSettings.height=modal.content.outerHeight(true);resized.height=true}modal.contentWrapper.css({opacity:1});if(!resizing)modal.contentWrapper.hide()}if(currentSettings.type!='image'&&currentSettings.type!='swf'){currentSettings.width=Math.max(currentSettings.width,currentSettings.minWidth);currentSettings.height=Math.max(currentSettings.height,currentSettings.minHeight)}var outerWrapper=getOuter(modal.contentWrapper);var outerWrapper2=getOuter(modal.wrapper);var outerContent=getOuter(modal.content);var tmp={content:{width:currentSettings.width,height:currentSettings.height},wrapper2:{width:currentSettings.width+outerContent.w.total,height:currentSettings.height+outerContent.h.total},wrapper:{width:currentSettings.width+outerContent.w.total+outerWrapper2.w.total,height:currentSettings.height+outerContent.h.total+outerWrapper2.h.total}};if(currentSettings.resizable){var maxHeight=modal.blockerVars?modal.blockerVars.height:$(window).height()-outerWrapper.h.border-(tmp.wrapper.height-currentSettings.height);var maxWidth=modal.blockerVars?modal.blockerVars.width:$(window).width()-outerWrapper.w.border-(tmp.wrapper.width-currentSettings.width);maxHeight-=currentSettings.padding*2;maxWidth-=currentSettings.padding*2;if(tmp.content.height>maxHeight||tmp.content.width>maxWidth){if(currentSettings.type=='image'||currentSettings.type=='swf'){var useW=currentSettings.imgWidth?currentSettings.imgWidth:currentSettings.width;var useH=currentSettings.imgHeight?currentSettings.imgHeight:currentSettings.height;var diffW=tmp.content.width-useW;var diffH=tmp.content.height-useH;if(diffH<0)diffH=0;if(diffW<0)diffW=0;var calcH=maxHeight-diffH;var calcW=maxWidth-diffW;var ratio=Math.min(calcH/useH,calcW/useW);calcW=Math.floor(useW*ratio);calcH=Math.floor(useH*ratio);tmp.content.height=calcH+diffH;tmp.content.width=calcW+diffW}else{tmp.content.height=Math.min(tmp.content.height,maxHeight);tmp.content.width=Math.min(tmp.content.width,maxWidth)}tmp.wrapper2={width:tmp.content.width+outerContent.w.total,height:tmp.content.height+outerContent.h.total};tmp.wrapper={width:tmp.content.width+outerContent.w.total+outerWrapper2.w.total,height:tmp.content.height+outerContent.h.total+outerWrapper2.h.total}}}if(currentSettings.type=='swf'){$('object, embed',modal.content).attr('width',tmp.content.width).attr('height',tmp.content.height)}else if(currentSettings.type=='image'){$('img',modal.content).css({width:tmp.content.width,height:tmp.content.height})}modal.content.css($.extend({},tmp.content,currentSettings.cssOpt.content));modal.wrapper.css($.extend({},tmp.wrapper2,currentSettings.cssOpt.wrapper2));if(!resizing)modal.contentWrapper.css($.extend({},tmp.wrapper,currentSettings.cssOpt.wrapper));if(currentSettings.type=='image'&&currentSettings.addImageDivTitle){$('img',modal.content).removeAttr('alt');var divTitle=$('div',modal.content);if(currentSettings.title!=currentSettings.defaultImgAlt&&currentSettings.title){if(divTitle.length==0){divTitle=$('<div>'+currentSettings.title+'</div>');modal.content.append(divTitle)}if(currentSettings.setWidthImgTitle){var outerDivTitle=getOuter(divTitle);divTitle.css({width:(tmp.content.width+outerContent.w.padding-outerDivTitle.w.total)+'px'})}}else if(divTitle.length=0){divTitle.remove()}}if(currentSettings.title)setTitle();tmp.wrapper.borderW=outerWrapper.w.border;tmp.wrapper.borderH=outerWrapper.h.border;setCurrentSettings(tmp.wrapper);setMargin()}function removeModal(e){debug('removeModal');if(e)e.preventDefault();if(modal.full&&modal.ready){$(document).unbind('keydown.nyroModal');if(!currentSettings.blocker)$(window).unbind('resize.nyroModal');modal.ready=false;modal.anim=true;modal.closing=true;if(modal.loadingShown||modal.transition){currentSettings.hideLoading(modal,currentSettings,function(){modal.loading.hide();modal.loadingShown=false;modal.transition=false;currentSettings.hideBackground(modal,currentSettings,endRemove)})}else{if(fixFF)modal.content.css({position:''});modal.wrapper.css({overflow:'hidden'});modal.content.css({overflow:'hidden'});$('iframe',modal.content).hide();if($.isFunction(currentSettings.beforeHideContent)){currentSettings.beforeHideContent(modal,currentSettings,function(){currentSettings.hideContent(modal,currentSettings,function(){endHideContent();currentSettings.hideBackground(modal,currentSettings,endRemove)})})}else{currentSettings.hideContent(modal,currentSettings,function(){endHideContent();currentSettings.hideBackground(modal,currentSettings,endRemove)})}}}if(e)return false}function showContentOrLoading(){debug('showContentOrLoading');if(modal.ready&&!modal.anim){if(modal.dataReady){if(modal.tmp.html()){modal.anim=true;if(modal.transition){fillContent();modal.animContent=true;currentSettings.hideTransition(modal,currentSettings,function(){modal.loading.hide();modal.transition=false;modal.loadingShown=false;endShowContent()})}else{currentSettings.hideLoading(modal,currentSettings,function(){modal.loading.hide();modal.loadingShown=false;fillContent();setMarginLoading();setMargin();modal.animContent=true;currentSettings.showContent(modal,currentSettings,endShowContent)})}}}else if(!modal.loadingShown&&!modal.transition){modal.anim=true;modal.loadingShown=true;if(modal.error)loadingError();else modal.loading.html(currentSettings.contentLoading);$(currentSettings.closeSelector,modal.loading).unbind('click.nyroModal').bind('click.nyroModal',removeModal);setMarginLoading();currentSettings.showLoading(modal,currentSettings,function(){modal.anim=false;showContentOrLoading()})}}}function ajaxLoaded(data){debug('AjaxLoaded: '+this.url);if(currentSettings.selector){var tmp={};var i=0;data=data.replace(/\r\n/gi,'nyroModalLN').replace(/<script(.|\s)*?\/script>/gi,function(x){tmp[i]=x;return'<pre style="display: none" class=nyroModalScript rel="'+(i++)+'"></pre>'});data=$('<div>'+data+'</div>').find(currentSettings.selector).html().replace(/<pre style="display: none;?" class="?nyroModalScript"? rel="(.?)"><\/pre>/gi,function(x,y,z){return tmp[y]}).replace(/nyroModalLN/gi,"\r\n")}modal.tmp.html(filterScripts(data));if(modal.tmp.html()){modal.dataReady=true;showContentOrLoading()}else loadingError()}function formDataLoaded(){debug('formDataLoaded');var jFrom=$(currentSettings.from);jFrom.attr('action',jFrom.attr('action')+currentSettings.selector);jFrom.attr('target','');$('input[name='+currentSettings.formIndicator+']',currentSettings.from).remove();var iframe=modal.tmp.children('iframe');var iframeContent=iframe.unbind('load').contents().find(currentSettings.selector||'body').not('script[src]');iframe.attr('src','about:blank');modal.tmp.html(iframeContent.html());if(modal.tmp.html()){modal.dataReady=true;showContentOrLoading()}else loadingError()}function iframeLoaded(){if((window.location.hostname&&currentSettings.url.indexOf(window.location.hostname)>-1)||currentSettings.url.indexOf('http://')){var iframe=$('iframe',modal.full).contents();var tmp={};if(currentSettings.titleFromIframe){tmp.title=iframe.find('title').text();if(!tmp.title){try{tmp.title=iframe.find('title').html()}catch(err){}}}var body=iframe.find('body');if(!currentSettings.height&&body.height())tmp.height=body.height();if(!currentSettings.width&&body.width())tmp.width=body.width();$.extend(initSettingsSize,tmp);$.nyroModalSettings(tmp)}}function galleryCounts(nb,total,elts,settings){if(total>1)settings.title+=(settings.title?' - ':'')+nb+'/'+total}function endHideContent(){debug('endHideContent');modal.anim=false;if(contentEltLast){contentEltLast.append(modal.content.contents());contentEltLast=null}else if(contentElt){contentElt.append(modal.content.contents());contentElt=null}modal.content.empty();gallery={};modal.contentWrapper.hide().children().remove().empty().attr('style','').hide();if(modal.closing||modal.transition)modal.contentWrapper.hide();modal.contentWrapper.css(currentSettings.cssOpt.wrapper).append(modal.content);showContentOrLoading()}function endRemove(){debug('endRemove');$(document).unbind('keydown',keyHandler);modal.anim=false;modal.full.remove();modal.full=null;if(isIE6){body.css({height:'',width:'',position:'',overflow:'',marginLeft:'',marginRight:''});$('html').css({overflow:''})}if($.isFunction(currentSettings.endRemove))currentSettings.endRemove(modal,currentSettings)}function endBackground(){debug('endBackground');modal.ready=true;modal.anim=false;showContentOrLoading()}function endShowContent(){debug('endShowContent');modal.anim=false;modal.animContent=false;modal.contentWrapper.css({opacity:''});fixFF=/mozilla/.test(userAgent)&&!/(compatible|webkit)/.test(userAgent)&&parseFloat(browserVersion)<1.9&&currentSettings.type!='image';if(fixFF)modal.content.css({position:'fixed'});modal.content.append(modal.scriptsShown);if(currentSettings.type=='iframe')modal.content.find('iframe').attr('src',currentSettings.url);if($.isFunction(currentSettings.endShowContent))currentSettings.endShowContent(modal,currentSettings);if(shouldResize){shouldResize=false;$.nyroModalSettings({width:currentSettings.setWidth,height:currentSettings.setHeight});delete currentSettings['setWidth'];delete currentSettings['setHeight']}if(resized.width)setCurrentSettings({width:null});if(resized.height)setCurrentSettings({height:null})}function getHash(url){if(typeof url=='string'){var hashPos=url.indexOf('#');if(hashPos>-1)return url.substring(hashPos)}return''}function filterScripts(data){if(typeof data=='string')data=data.replace(/<\/?(html|head|body)([^>]*)>/gi,'');var tmp=new Array();$.each($.clean({0:data},this.ownerDocument),function(){if($.nodeName(this,"script")){if(!this.src||$(this).attr('rel')=='forceLoad'){if($(this).attr('rev')=='shown')modal.scriptsShown.push(this);else modal.scripts.push(this)}}else tmp.push(this)});return tmp}function getOuter(elm){elm=elm.get(0);var ret={h:{margin:getCurCSS(elm,'marginTop')+getCurCSS(elm,'marginBottom'),border:getCurCSS(elm,'borderTopWidth')+getCurCSS(elm,'borderBottomWidth'),padding:getCurCSS(elm,'paddingTop')+getCurCSS(elm,'paddingBottom')},w:{margin:getCurCSS(elm,'marginLeft')+getCurCSS(elm,'marginRight'),border:getCurCSS(elm,'borderLeftWidth')+getCurCSS(elm,'borderRightWidth'),padding:getCurCSS(elm,'paddingLeft')+getCurCSS(elm,'paddingRight')}};ret.h.outer=ret.h.margin+ret.h.border;ret.w.outer=ret.w.margin+ret.w.border;ret.h.inner=ret.h.padding+ret.h.border;ret.w.inner=ret.w.padding+ret.w.border;ret.h.total=ret.h.outer+ret.h.padding;ret.w.total=ret.w.outer+ret.w.padding;return ret}function getCurCSS(elm,name){var ret=parseInt($.curCSS(elm,name,true));if(isNaN(ret))ret=0;return ret}function debug(msg){if($.fn.nyroModal.settings.debug||currentSettings&&currentSettings.debug)nyroModalDebug(msg,modal,currentSettings||{})}function showBackground(elts,settings,callback){elts.bg.css({opacity:0}).fadeTo(500,0.75,callback)}function hideBackground(elts,settings,callback){elts.bg.fadeOut(300,callback)}function showLoading(elts,settings,callback){elts.loading.css({marginTop:settings.marginTopLoading+'px',marginLeft:settings.marginLeftLoading+'px',opacity:0}).show().animate({opacity:1},{complete:callback,duration:400})}function hideLoading(elts,settings,callback){callback()}function showContent(elts,settings,callback){elts.loading.css({marginTop:settings.marginTopLoading+'px',marginLeft:settings.marginLeftLoading+'px'}).show().animate({width:settings.width+'px',height:settings.height+'px',marginTop:settings.marginTop+'px',marginLeft:settings.marginLeft+'px'},{duration:350,complete:function(){elts.contentWrapper.css({width:settings.width+'px',height:settings.height+'px',marginTop:settings.marginTop+'px',marginLeft:settings.marginLeft+'px'}).show();elts.loading.fadeOut(200,callback)}})}function hideContent(elts,settings,callback){elts.contentWrapper.animate({height:'50px',width:'50px',marginTop:(-(25+settings.borderH)/2+settings.marginScrollTop)+'px',marginLeft:(-(25+settings.borderW)/2+settings.marginScrollLeft)+'px'},{duration:350,complete:function(){elts.contentWrapper.hide();callback()}})}function showTransition(elts,settings,callback){elts.loading.css({marginTop:elts.contentWrapper.css('marginTop'),marginLeft:elts.contentWrapper.css('marginLeft'),height:elts.contentWrapper.css('height'),width:elts.contentWrapper.css('width'),opacity:0}).show().fadeTo(400,1,function(){elts.contentWrapper.hide();callback()})}function hideTransition(elts,settings,callback){elts.contentWrapper.hide().css({width:settings.width+'px',height:settings.height+'px',marginLeft:settings.marginLeft+'px',marginTop:settings.marginTop+'px',opacity:1});elts.loading.animate({width:settings.width+'px',height:settings.height+'px',marginLeft:settings.marginLeft+'px',marginTop:settings.marginTop+'px'},{complete:function(){elts.contentWrapper.show();elts.loading.fadeOut(400,function(){elts.loading.hide();callback()})},duration:350})}function resize(elts,settings,callback){elts.contentWrapper.animate({width:settings.width+'px',height:settings.height+'px',marginLeft:settings.marginLeft+'px',marginTop:settings.marginTop+'px'},{complete:callback,duration:400})}function updateBgColor(elts,settings,callback){if(!$.fx.step.backgroundColor){elts.bg.css({backgroundColor:settings.bgColor});callback()}else elts.bg.animate({backgroundColor:settings.bgColor},{complete:callback,duration:400})}$($.fn.nyroModal.settings.openSelector).nyroModal()});var tmpDebug='';function nyroModalDebug(msg,elts,settings){if(elts.full&&elts.bg){elts.bg.prepend(msg+'<br />'+tmpDebug);tmpDebug=''}else tmpDebug+=msg+'<br />'}
(function($) {
	$.widget("ui.combobox", {
		_create: function() {
			var self = this;
			var select = this.element;
			select.hide();
			var opts = new Array();
			$('option',select).each(function(index) {
				var opt = new Object();
				opt.value = $(this).val();
				opt.label = $(this).text();
				opts[opts.length] = opt;
			});
			var input = $("<input>");
			input.insertAfter(select);
			input.autocomplete({
				source: opts,
				delay: 0,
				change: function(event, ui) {
					if (!ui.item) {
						var enteredString = $(this).val();
						var stringMatch = false;
						for (var i=0; i < opts.length; i++){
							if(opts[i].label.toLowerCase() == enteredString.toLowerCase()){
								select.val(opts[i].value);
								$(this).val(opts[i].label);
								stringMatch = true;
								break;
							}
						}
						if(!stringMatch){
							$(this).val($(':selected',select).text());
						}
						return false;
					}
				},
				select: function(event, ui) {
					select.val(ui.item.value);
					$(this).val(ui.item.label);
					return false;
				},
				open: function(event, ui) {
					input.attr("menustatus","open");
				},
				close: function(event, ui) {
					input.attr("menustatus","closed");
				},
				minLength: 0
			});
			input.addClass("ui-widget ui-widget-content ui-corner-all combobox");
			input.val($(':selected',select).text());
			input.click(function(){
				$(this).val("");
			});
			input.attr("menustatus","closed");
			var form = $(input).parents('form:first');
			$(form).submit(function(e){
				return (input.attr('menustatus') == 'closed');
			});
			input.css("margin",0);
			input.css("padding","3px 5px");
			input.live("blur", function(event) {
				var autocomplete = $(this).data("autocomplete");
				if (autocomplete.selectedItem) { return; }
				var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i");
				autocomplete.widget().children(".ui-menu-item").each(function() {
					var item = $(this).data("item.autocomplete");
					if (matcher.test(item.label || item.value || item)) {
						autocomplete.selectedItem = item;
						return false;
					}
				});
				if (autocomplete.selectedItem) {
					autocomplete._trigger("select", event, { item: autocomplete.selectedItem });
				}
			});
		}
	});
})(jQuery);
(function($){$.fn.editable=function(target,options){if('disable'==target){$(this).data('disabled.editable',true);return;}
if('enable'==target){$(this).data('disabled.editable',false);return;}
if('destroy'==target){$(this).unbind($(this).data('event.editable')).removeData('disabled.editable').removeData('event.editable');return;}
var settings=$.extend({},$.fn.editable.defaults,{target:target},options);var plugin=$.editable.types[settings.type].plugin||function(){};var submit=$.editable.types[settings.type].submit||function(){};var buttons=$.editable.types[settings.type].buttons||$.editable.types['defaults'].buttons;var content=$.editable.types[settings.type].content||$.editable.types['defaults'].content;var element=$.editable.types[settings.type].element||$.editable.types['defaults'].element;var reset=$.editable.types[settings.type].reset||$.editable.types['defaults'].reset;var callback=settings.callback||function(){};var onedit=settings.onedit||function(){};var onsubmit=settings.onsubmit||function(){};var onreset=settings.onreset||function(){};var onerror=settings.onerror||reset;if(settings.tooltip){$(this).attr('title',settings.tooltip);}
settings.autowidth='auto'==settings.width;settings.autoheight='auto'==settings.height;return this.each(function(){var self=this;var savedwidth=$(self).width();var savedheight=$(self).height();$(this).data('event.editable',settings.event);if(!$.trim($(this).html())){$(this).html(settings.placeholder);}
$(this).bind(settings.event,function(e){if(true===$(this).data('disabled.editable')){return;}
if(self.editing){return;}
if(false===onedit.apply(this,[settings,self])){return;}
e.preventDefault();e.stopPropagation();if(settings.tooltip){$(self).removeAttr('title');}
if(0==$(self).width()){settings.width=savedwidth;settings.height=savedheight;}else{if(settings.width!='none'){settings.width=settings.autowidth?$(self).width():settings.width;}
if(settings.height!='none'){settings.height=settings.autoheight?$(self).height():settings.height;}}
if($(this).html().toLowerCase().replace(/(;|")/g,'')==settings.placeholder.toLowerCase().replace(/(;|")/g,'')){$(this).html('');}
self.editing=true;self.revert=$(self).html();$(self).html('');var form=$('<form />');if(settings.cssclass){if('inherit'==settings.cssclass){form.attr('class',$(self).attr('class'));}else{form.attr('class',settings.cssclass);}}
if(settings.style){if('inherit'==settings.style){form.attr('style',$(self).attr('style'));form.css('display',$(self).css('display'));}else{form.attr('style',settings.style);}}
var input=element.apply(form,[settings,self]);var input_content;if(settings.loadurl){var t=setTimeout(function(){input.disabled=true;content.apply(form,[settings.loadtext,settings,self]);},100);var loaddata={};loaddata[settings.id]=self.id;if($.isFunction(settings.loaddata)){$.extend(loaddata,settings.loaddata.apply(self,[self.revert,settings]));}else{$.extend(loaddata,settings.loaddata);}
$.ajax({type:settings.loadtype,url:settings.loadurl,data:loaddata,async:false,success:function(result){window.clearTimeout(t);input_content=result;input.disabled=false;}});}else if(settings.data){input_content=settings.data;if($.isFunction(settings.data)){input_content=settings.data.apply(self,[self.revert,settings]);}}else{input_content=self.revert;}
content.apply(form,[input_content,settings,self]);input.attr('name',settings.name);buttons.apply(form,[settings,self]);$(self).append(form);plugin.apply(form,[settings,self]);$(':input:visible:enabled:first',form).focus();if(settings.select){input.select();}
input.keydown(function(e){if(e.keyCode==27){e.preventDefault();reset.apply(form,[settings,self]);}});var t;if('cancel'==settings.onblur){input.blur(function(e){t=setTimeout(function(){reset.apply(form,[settings,self]);},500);});}else if('submit'==settings.onblur){input.blur(function(e){t=setTimeout(function(){form.submit();},200);});}else if($.isFunction(settings.onblur)){input.blur(function(e){settings.onblur.apply(self,[input.val(),settings]);});}else{input.blur(function(e){});}
form.submit(function(e){if(t){clearTimeout(t);}
e.preventDefault();if(false!==onsubmit.apply(form,[settings,self])){if(false!==submit.apply(form,[settings,self])){if($.isFunction(settings.target)){var str=settings.target.apply(self,[input.val(),settings]);$(self).html(str);self.editing=false;callback.apply(self,[self.innerHTML,settings]);if(!$.trim($(self).html())){$(self).html(settings.placeholder);}}else{var submitdata={};submitdata[settings.name]=input.val();submitdata[settings.id]=self.id;if($.isFunction(settings.submitdata)){$.extend(submitdata,settings.submitdata.apply(self,[self.revert,settings]));}else{$.extend(submitdata,settings.submitdata);}
if('PUT'==settings.method){submitdata['_method']='put';}
$(self).html(settings.indicator);var ajaxoptions={type:'POST',data:submitdata,dataType:'html',url:settings.target,success:function(result,status){if(ajaxoptions.dataType=='html'){$(self).html(result);}
self.editing=false;callback.apply(self,[result,settings]);if(!$.trim($(self).html())){$(self).html(settings.placeholder);}},error:function(xhr,status,error){onerror.apply(form,[settings,self,xhr]);}};$.extend(ajaxoptions,settings.ajaxoptions);$.ajax(ajaxoptions);}}}
$(self).attr('title',settings.tooltip);return false;});});this.reset=function(form){if(this.editing){if(false!==onreset.apply(form,[settings,self])){$(self).html(self.revert);self.editing=false;if(!$.trim($(self).html())){$(self).html(settings.placeholder);}
if(settings.tooltip){$(self).attr('title',settings.tooltip);}}}};});};$.editable={types:{defaults:{element:function(settings,original){var input=$('<input type="hidden"></input>');$(this).append(input);return(input);},content:function(string,settings,original){$(':input:first',this).val(string);},reset:function(settings,original){original.reset(this);},buttons:function(settings,original){var form=this;if(settings.submit){if(settings.submit.match(/>$/)){var submit=$(settings.submit).click(function(){if(submit.attr("type")!="submit"){form.submit();}});}else{var submit=$('<button type="submit" />');submit.html(settings.submit);}
$(this).append(submit);}
if(settings.cancel){if(settings.cancel.match(/>$/)){var cancel=$(settings.cancel);}else{var cancel=$('<button type="cancel" />');cancel.html(settings.cancel);}
$(this).append(cancel);$(cancel).click(function(event){if($.isFunction($.editable.types[settings.type].reset)){var reset=$.editable.types[settings.type].reset;}else{var reset=$.editable.types['defaults'].reset;}
reset.apply(form,[settings,original]);return false;});}}},text:{element:function(settings,original){var input=$('<input />');if(settings.width!='none'){input.width(settings.width);}
if(settings.height!='none'){input.height(settings.height);}
input.attr('autocomplete','off');$(this).append(input);return(input);}},textarea:{element:function(settings,original){var textarea=$('<textarea />');if(settings.rows){textarea.attr('rows',settings.rows);}else if(settings.height!="none"){textarea.height(settings.height);}
if(settings.cols){textarea.attr('cols',settings.cols);}else if(settings.width!="none"){textarea.width(settings.width);}
$(this).append(textarea);return(textarea);}},select:{element:function(settings,original){var select=$('<select />');$(this).append(select);return(select);},content:function(data,settings,original){if(String==data.constructor){eval('var json = '+data);}else{var json=data;}
for(var key in json){if(!json.hasOwnProperty(key)){continue;}
if('selected'==key){continue;}
var option=$('<option />').val(key).append(json[key]);$('select',this).append(option);}
$('select',this).children().each(function(){if($(this).val()==json['selected']||$(this).text()==$.trim(original.revert)){$(this).attr('selected','selected');}});}}},addInputType:function(name,input){$.editable.types[name]=input;}};$.fn.editable.defaults={name:'value',id:'id',type:'text',width:'auto',height:'auto',event:'click.editable',onblur:'cancel',loadtype:'GET',loadtext:'Loading...',placeholder:'Click to edit',loaddata:{},submitdata:{},ajaxoptions:{}};})(jQuery);