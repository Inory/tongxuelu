/**
 * 计算已经输入的字数，超出最大值时，字数标红
 * @param ipt
 * @param count
 */
function bindCountWordEvent(ipt, count, max, undefined){
	ipt.keyup(function(){
		var len = parseInt(utf8strlen(ipt.val()) / 2);
		if (max != undefined && parseInt(max) > 0){
			var remaining = parseInt(parseInt(max) - len);
			if(remaining < 0){
				count.css({"color" : "red"});
			}
			else{
				count.css({"color" : ""});
			}
		}
		count.html(len);
	});
}

/**
 * 计算剩余的可输入字数，超出最大值时，字数标红
 * @param ipt jQuery obj
 * @param count
 * @param max
 */
function bindCountRemainingWordEvent(ipt, count, max){
	ipt.bind('keyup change focus', function(){
		var len = utf8strlen(ipt.val()) / 2;
		var remaining = parseInt(max - len);
		if(remaining < 0){
			count.css({"color" : "red"});
		}
		else{
			count.css({"color" : ""});
		}
		count.html(remaining);
	});
}

function _showBox(btn, box, type){
	var x = 0,y = 0;
	if(type == 'add'){
		x = getElePosLeft(btn) - btn.width() / 2;
		y = getElePosTop(btn) + btn.height() + 5;
	}
	else if(type == 'biginfo'){
		x = getElePosLeft(btn) + btn.width();
		y = getElePosTop(btn) + 3;
	}
	else if(type == 'fb'){
		var p = new CompWS;
		btnX = getElePosLeft(btn);
		if(btnX > p.width - box.width() - 100){
			x = btnX - box.width();
		}
		else{
			x = btnX + btn.width();
		}
		y = getElePosTop(btn) + 3;
	}
	setAbsPosition(box, x, y);
	box.show();
}


//position 兼容代码
function CompWS(){
	var de = document.documentElement,db = document.body;
	var L = (window.pageXOffset|| (de&&de.scrollLeft) || db.scrollLeft || 0);
	var T = (window.pageYOffset|| (de&&de.scrollTop) || db.scrollTop || 0);
	var W = (window.innerWidth || (de&&de.clientWidth) || db.clientWidth || 0);
	var H = (window.innerHeight|| (de&&de.clientHeight) || db.clientHeight || 0);
	var pW = (db.scrollWidth  || db.offsetWidth  || 0);
	var pH = (db.scrollHeight || db.offsetHeight || 0);
	return { top: T, left: L, width: W, height: H, pWidth:pW, pHeight:pH };
}

//ele is a jquery object
function getElePosLeft(ele){
	return ele.scrollLeft() + ele.offset().left;
}

function getElePosTop(ele){
	return ele.scrollTop() + ele.offset().top;
}

function bodyCenterFixed(ele){
	comp = new CompWS();
	ele.css('position', 'fixed');
	ele.css('left', (comp.width - ele.width()) / 2);
	ele.css('top', (comp.height - ele.height()) / 2);
}

function bodyCenterAbs(ele){
	comp = new CompWS();
	ele.css('position', 'absolute');
	ele.css('left', comp.left + (comp.width - ele.width()) / 2);
	ele.css('top', comp.top + (comp.height - ele.height()) / 2);
}

function setAbsPosition(ele, x, y){
	ele.css('position', 'absolute');
	if(typeof x != 'undefined' && x != 0){
		ele.css('left', x);
	}
	if(typeof y != 'undefined' && y != 0){
		ele.css('top', y);
	}
}

function bodyLeftCenter(ele){
	var comp = new CompWS();
	ele.css('position', 'fixed');
	ele.css('left', 0);
	ele.css('top', comp.top + (comp.height - ele.height()) / 2);
}

function bodyRightCenter(ele){
	comp = new CompWS();
	ele.css('position', 'fixed');
	ele.css('left', comp.left + comp.width - ele.width());
	ele.css('top', comp.top + (comp.height - ele.height()) / 2);
}


function isArray(obj){
	return Object.prototype.toString.call(obj) === '[object Array]';      
}

function isInArray(val, arr){
	var testStr = ',' + arr.join(',') + ',';
	return testStr.indexOf(',' + val + ',') != -1;
}

function utf8strlen(str){
	str = str.replace(/[^\u00-\uff]/g, '**');
	return str.length;
}

// 参数(图片,允许的宽度,允许的高度)
function _drawImage(ImgD, w, h){    
    var image = new Image();    
    image.src = ImgD.src;
    if(image.width > 0 && image.height > 0){    
      if(image.width / image.height >= w/h){    
          if(image.width > w){
              ImgD.width = w;    
              ImgD.height = (image.height * w) / image.width;    
          }
          else{    
              ImgD.width = image.width;      
              ImgD.height = image.height;    
          }    
      }else{    
          if(image.height > h){      
              ImgD.height = h;    
              ImgD.width = (image.width * h) / image.height;            
          }
          else{    
              ImgD.width = image.width;      
              ImgD.height = image.height;    
          }    
      }    
    }    
} 

function rand(min, max){
	return parseInt(min + max * Math.random());
}

function loadScript(url,callback){
    var script=document.createElement('script');
    script.type='text/javascript';
    if( script.readyState ){
        script.onreadystatechange = function(){
             if( script.readyState == 'loaded' || script.readyState == 'complete' ){
                 script.onreadystatechange = null ;
                 callback();
             }
        };
    }
    else{
        script.onload=function(){
            callback();
        };
    }
    script.src=url;
    document.getElementsByTagName('head')[0].appendChild(script);
}


//----JQuery plugin
//JQuery outer html
jQuery.fn.outerHTML = function(s){
	ele = document.createElement('div');  
	return (s) ? this.before(s).remove() : jQuery(ele).append(this.eq(0).clone()).html();
};

jQuery.fn.extend({
    getCurPos: function(){
        var e=$(this).get(0);
        e.focus();
        if(e.selectionStart){    //FF
            return e.selectionStart;  
        }
        if(document.selection){    //IE
            var r = document.selection.createRange();  
            if (r == null) {
                return e.value.length;  
            }
            var re = e.createTextRange();
            var rc = re.duplicate();
            re.moveToBookmark(r.getBookmark());
            rc.setEndPoint('EndToStart', re);
            return rc.text.length;
        }
        return e.value.length;
    },  
    setCurPos: function(pos) {
        var e=$(this).get(0);
        e.focus();
        if (e.setSelectionRange) {
            e.setSelectionRange(pos, pos);
        } else if (e.createTextRange) {
            var range = e.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    },
    insertAtCursor : function(myValue) {
    	var e=$(this).get(0);
    	var pos = $(this).getCurPos() + myValue.length;
    	// IE support
    	if (document.selection) {
    		e.focus();
    		sel = document.selection.createRange();
    		sel.text = myValue;
    	}
    	// MOZILLA/NETSCAPE support
    	else if (e.selectionStart || e.selectionStart == '0') {
    		var startPos = e.selectionStart;
    		var endPos = e.selectionEnd;
    		e.value = e.value.substring(0, startPos)+  myValue+ e.value.substring(endPos, e.value.length);
    	}
    	else {
    		e.value += myValue;
    	}
    	$(this).setCurPos(pos);
	}
});