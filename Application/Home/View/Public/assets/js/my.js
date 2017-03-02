function check() {
	//alert('111222');
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  	//alert('111');
			 // 获取已激活的标签页的名称
			 var activeTab = $(e.target).text().trim(); 
			// alert('111');
			 var tab1 = document.getElementById('tab1');
			 //alert(tab1);
			 var inputs = tab1.getElementsByTagName('input');
			 var svns = new Array();
			 var svrs = new Array();
			 var filepaths = new Array();
			// alert(inputs);
			 for(i=0;i<inputs.length;i++) {
			 	var obj = inputs[i];
			 	var svn = '';
			 	var svr = '';
			 	var filepath = '';
			 	if(obj.type == 'checkbox' && obj.checked) {
			 		if(obj.value.indexOf('-') > 0) {
			 			svn = obj.value.substr(0,(obj.value.indexOf('-'))) + 'svn';
			 			filepath = obj.value.substr(0,(obj.value.indexOf('-'))) + 'path';
			 		}else {
			 			svn = obj.value + 'svn';
			 			filepath = obj.value + 'path';
			 		}

			 		if(svns.indexOf(svn) < 0) {
			 			svns.push(svn);
			 		}

			 		if(filepaths.indexOf(filepath) < 0) {
			 			filepaths.push(filepath);
			 		}

			 		svrs.push(obj.name);
			 		
			 	}
			 }

			 
		switch(activeTab) {
			case '输入要部署系统的svn地址':
				writeTab2(svns);
				break;
			case '上传额外的部署文件':
				writeTab3(filepaths);
				break;
			case '确认需要部署的内容':
				writeTab4(svrs,svns,filepaths);
				break;
			case '完成部署':
				document.getElementById('form1').submit();
				break;

			} 
			});

}


function writeTab2(svns) {
	var p = document.getElementById('tab2');
	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">请输入要部署系统的SVN地址</p><br /></div></div>';

	for(i=0;i<svns.length;i++) {
		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + svns[i].substr(0,svns[i].indexOf('svn')) + ' svn tag</label><div class="col-md-9"><input type="text" id="' + svns[i] + '" name="' + svns[i] + '" class="form-control" placeholder="' + svns[i].substr(0,svns[i].indexOf('svn')) + '  svn tag"><span class="help-block">输入' + svns[i].substr(0,svns[i].indexOf('svn')) + '的svn地址</span></div></div>';
	}

	p.innerHTML = html;

}

function writeTab3(filepaths) {
	var p = document.getElementById('tab3');
	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">上传额外的部署文件</p><br /></div></div>';

	for(i=0;i<filepaths.length;i++) {
		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外文件部署路径</label><div class="col-md-9"><input type="text" id="' + filepaths[i] + '" name="' + filepaths[i] + '" class="form-control" placeholder="' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外文件部署路径"><span class="help-block">输入' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外文件部署路径</span></div></div>';
		filename = filepaths[i].replace('path','file');
		html = html + '<div class="form-group"><label class="col-md-3 control-label" for="' + filename + '">上传' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + '额外部署文件</label><div class="col-md-9"><input type="file" id="' + filename + '" name="' + filename + '" multiple /><br /></div></div>';
	}

	p.innerHTML = html;


}

function writeTab4(svrs,svns,filepaths) {
	var p = document.getElementById('tab4');
	var html = '<div class="col-md-3"></div><div class="col-md-9"><h4><strong>1. 要部署系统的服务器如下：</strong></h4>';
	
	//var svrs= new Array("webfrontsvr","wechatsvr1","wechatsvr2","nodecoresvr1","nodecoresvr2","pcwebsvr1","pcwebsvr2")
	//alert(html);
	
	for(i=0;i<svrs.length;i++) {
		

		if(document.getElementById(svrs[i]).checked) {
			//alert(document.getElementById(svrs[i]).checked);
			html = html + '<p><li>' + document.getElementById(svrs[i]).value + '</li></p>';

			//alert(html);
			//html = html + "<br><p>1111</p>";
		}
	}

	

	//var svns = new Array('webfrontsvn','wechatsvn','nodecoresvn','pcwebsvn');
	//alert(svns[3]);
	html = html + '</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><h4><strong>2. 要部署系统的svn地址如下：</strong></h4>';

	for(i=0;i<svns.length;i++) {

		if(document.getElementById(svns[i]).value != '') {
	    	html = html + '<p><li>' + svns[i].substr(0,svns[i].indexOf('svn')) + "的svn地址：" + document.getElementById(svns[i]).value + "</li></p>";
		}
	}

	//var filepaths = new Array('webfrontpath','wechatpath','nodecorepath','pcwebpath');
	html = html + '</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><h4><strong>3. 要额外部署的文件路径如下：</strong></h4>';

	for(i=0;i<filepaths.length;i++) {

		if(document.getElementById(filepaths[i]).value != '') {
			html = html + '<p><li>' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + "需要额外部署的路径：" + document.getElementById(filepaths[i]).value + "</li></p>";
			filename = filepaths[i].replace('path','file');
			html = html + '<p class="col-md3"><li>' + filepaths[i].substr(0,filepaths[i].indexOf('path')) + "需要额外部署的文件：" + document.getElementById(filename).value + "</li></p>";
		}
	}

	
	html = html + 
	'</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><div class="form-group"><div class="checkbox-custom checkbox-default bk-margin-bottom-10"><input id="accept" name="accept" type="checkbox"/><label for="accept"> 确认需要部署的内容 <a href="form-wizard.html#">Terms of Service</a></label></div></div></div>'

	p.innerHTML = html;
}

function deploycheck() {
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var activeTab = $(e.target).text().trim();
		var target = $(e.target).attr('href');
		var a = target.substr(target.indexOf('tab') + 3);
		var tab = '#tab' + (a -1);
		
		var inputs = $(tab).find('input');
		
		



		switch(activeTab) {
			case '选择要发布的系统及服务器':
				tab2(inputs);
				break;
			case '输入要部署系统的svn地址或上传程序包':
				tab3(inputs);
				break;
			case '上传额外的部署文件':
				tab4();
				break;
			case '设置系统发布顺序':
				tab5();
				break;
			case '确认需要部署的内容':
				tab6(inputs);
				break;
			case '完成部署':
			 	// document.getElementById('form1').submit();
			 	tab7();
			 	break;

		} 
			
	});
}


function tab2(inputs) {
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}
	
	var url = "{:U('Admin/Deploy/system','','')}";
	$.post('system',
	  {
	    project_ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab2');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">选择要发布的系统及服务器</p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {
	    		html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		var host = data[i]['host'];
	    		
	    		for(j=0;j<host.length;j++) {
	    			
	    			html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_id'] + '" name="h_' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_id'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		}
	    		html = html + '</div></div>';
	    	}
	    	p.innerHTML = html;
	    }
	  });
}


function tab3(inputs) {
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}


	
	var url = "{:U('Admin/Deploy/host','','')}";
	$.post('host',
	  {
	    host_ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab3');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">输入要部署系统的svn地址或上传程序包</p><br /></div></div><form action="{:U("Admin/Deploy/upload")}" id="pkg" method="post" enctype="multipart/form-data" class="form-horizontal">';
	    	for(i=0;i<data.length;i++) {

	    		if(data[i]['deploy_rule']['rule_name'].indexOf('SVN') > 0) {
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' svn tag</label><div class="col-md-9"><input type="text" id="' +  data[i]['system_id'] + '" name="svn_' +  data[i]['system_name'] + '" class="form-control" placeholder="' +  data[i]['system_name'] + '  svn tag"><span class="help-block">输入' +  data[i]['system_name'] + '的svn地址</span></div></div>';
	    		}else {
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="' + data[i]['system_id'] + '">上传' + data[i]['system_name'] + '已打包的部署文件</label><div class="col-md-9"><input type="file" id="' + data[i]['system_id'] + '" name="pkg_' + data[i]['system_name'] + '" multiple /><br /></div></div>';
	    		}

	    		// html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		// var host = data[i]['host'];
	    		
	    		// for(j=0;j<host.length;j++) {
	    			
	    		// 	html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_name'] + '" name="' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_name'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		// }
	    		// html = html + '</div></div>';
	    	}
	    	html = html + '</form>';
	    	p.innerHTML = html;
	    }
	  });
}

function tab4() {


	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}

	var url = "{:U('Admin/Deploy/host','','')}";
	$.post('host',
	  {
	    host_ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab4');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">上传额外的部署文件</p><br /></div></div><form action="{:U("Admin/Deploy/upload")}" id="extfile" method="post" enctype="multipart/form-data" class="form-horizontal">';
	    	for(i=0;i<data.length;i++) {

	    		
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + '额外文件部署路径</label><div class="col-md-9"><input type="text" id="' + data[i]['system_id'] + '" name="ep_' + data[i]['system_name'] + '" class="form-control" placeholder="' + data[i]['system_name'] + '额外文件部署路径"><span class="help-block">输入' + data[i]['system_name'] + '额外文件部署路径</span></div></div>';
		
	    		
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="' + data[i]['system_id'] + '">上传' + data[i]['system_name'] + '已打包的部署文件</label><div class="col-md-9"><input type="file" id="' + data[i]['system_id'] + '" name="ef_' + data[i]['system_name'] + '" multiple /><br /></div></div>';
	    		

	    		// html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		// var host = data[i]['host'];
	    		
	    		// for(j=0;j<host.length;j++) {
	    			
	    		// 	html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_name'] + '" name="' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_name'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		// }
	    		// html = html + '</div></div>';
	    	}
	    	html = html + '</form>';
	    	p.innerHTML = html;
	    }
	  });


}


function tab5() {
	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}


	
	var url = "{:U('Admin/Deploy/host','','')}";
	
	$.post('host',
	  {
	    host_ids:arr
	    
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	var p = document.getElementById('tab5');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static">设置系统发布顺序</p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {

	    		
	    			html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' 发布顺序</label><div class="col-md-3"><input type="text"  id="' +  data[i]['system_id'] + '" name="ord_' +  data[i]['system_name'] + '" class="form-control" placeholder="" value='+ (i+1) +'><span class="help-block">输入' +  data[i]['system_name'] + '的发布顺序，以数字1 2 3来表示</span></div></div>';
	    		

	    		// html = html + '<div class="form-group"><label class="col-md-3 control-label">' + data[i]['system_name'] + '</label><div class="col-md-9">';
	    		// var host = data[i]['host'];
	    		
	    		// for(j=0;j<host.length;j++) {
	    			
	    		// 	html = html + '<div class="checkbox-custom"><input type="checkbox" id="' + host[j]['host_name'] + '" name="' + host[j]['host_name'] + '" value="' + host[j]['host_id'] + '"><label for="' + host[j]['host_name'] + '"> ' + host[j]['host_name'] + '-' + host[j]['ipaddr'] + '</label></div>';
	    		// }
	    		// html = html + '</div></div>';
	    	}
	    	p.innerHTML = html;
	    }
	  });
}


function tab6() {

	$("[name='next']").val('Deploy');
	

	var inputs = $('#tab2').find('input');
	var arr = new Array();

	//alert(e.target.substr(e.target.indexOf('#')));
	for(i=0;i<inputs.length;i++) {
		var obj = inputs[i];
		
		if(obj.type == 'checkbox' && obj.checked) {
			
			arr.push(obj.value);
		}
	}

	var tab3inputs = $('#tab3').find('input');
	var arr2 = new Array();
	var t = 0;
	for(i=0;i<tab3inputs.length;i++) {
		var obj = tab3inputs[i];
		
		if(obj.type == 'file' && obj.value != '') {
			
			//arr2[t] = new Array();
			arr2.push(obj.id);
			arr2.push(obj.value);
			//alert(t);alert(arr2[t]['system_id']);
			
			t++;
		}else if(obj.type == 'text' && obj.value != '') {
			
			
			arr2.push(obj.id);
			arr2.push(obj.value);
			//alert(t);alert(arr2[t]['system_id']);
			//arr2.push(arr2[t]);
			t++;
		}
	}


	var tab4inputs = $('#tab4').find('input');
	var arr3 = new Array();
	t = 0;
	for(i=0;i<tab4inputs.length;i++) {
		var obj = tab4inputs[i];
		
		
			
			arr3.push(obj.id);
			arr3.push(obj.value);
			t++;
		
	}


	var tab5inputs = $('#tab5').find('input');
	var arr4 = new Array();
	t = 0;
	for(i=0;i<tab5inputs.length;i++) {
		var obj = tab5inputs[i];
		
		if(obj.type == 'text' && obj.value != '') {
			
			arr4.push(obj.id);
			arr4.push(obj.value);
		}
	}

	
	

	var url = "{:U('Admin/Deploy/summary','','')}";
	
	$.post('summary',
	  {
	    host_ids:arr,
	    svn:arr2,
	    extfile:arr3,
	    order:arr4
	  },
	  function(data,status){
	    if(status) {
	    	//alert(data);
	    	//
	    	
	    	//console.log(data);
	    	var p = document.getElementById('tab6');
	    	var html = '<div class="form-group"><div class="col-md-3"></div><div class="col-md-9"><p class="form-control-static"><h4><strong>确认需要部署的内容</strong></h4></p><br /></div></div>';
	    	for(i=0;i<data.length;i++) {

	    		
	    			// html = html + '<div class="form-group"><label class="col-md-3 control-label" for="text-input">' + data[i]['system_name'] + ' 发布顺序</label><div class="col-md-3"><input type="text"  id="order_' +  data[i]['system_id'] + '" name="order_' +  data[i]['system_id'] + '" class="form-control" placeholder="" value='+ (i+1) +'><span class="help-block">输入' +  data[i]['system_name'] + '的发布顺序，以数字1 2 3来表示</span></div></div>';
	    			html = html + '<hr/><ul><li>' + data[i]['system_name'] + '</li>';
	    			html = html + '<ul><li>所属项目：' + data[i]['project']['project_name'] + '</li>';
	    			html = html + '<li>部署规则：' + data[i]['deploy_rule']['rule_name'] + '</li>';
	    			if(data[i]['deploy_rule']['rule_name'].indexOf('SVN') > 0) {
	    				html = html + '<li>svn tag ：' + data[i]['deployinfo']['svn'] + '</li>';
	    			}else{
	    				html = html + '<li>程序包 ：' + data[i]['deployinfo']['pkg'] + '</li>';
	    			}
	    			html = html + '<li>部署路径：' + data[i]['deploy_path'] + '</li>';
	    			html = html + '<li>部署目标：' + data[i]['pkg_name'] + '</li>';
	    			html = html + '<li>额外部署文件：' + data[i]['deployinfo']['extfile'] + '</li>';
	    			html = html + '<li>额外部署文件路径：' + data[i]['deployinfo']['extpath'] + '</li>';
	    			html = html + '<li>备份路径：' + data[i]['backup_path'] + '</li>';
	    			html = html + '<li>依赖服务：' + data[i]['service']['service_name'] + '</li>';
	    			html = html + '<li>发布顺序：' + data[i]['deployinfo']['order'] + '</li>';
	    			html = html + '<li>部署主机：</li>';
	    			html = html + '<ul>';
	    			for(j=0;j<data[i]['host'].length;j++) {
	    				html = html + '<li>' + data[i]['host'][j]['host_name'] + '：' + data[i]['host'][j]['ipaddr'] + '</li>';
	    			}
	    			html = html + '</ul></ul></ul>';
	    		

	    		
	    	}
	    	html = html + 
	'</div><div class="col-md-12"><hr /></div><div class="col-md-3"></div><div class="col-md-9"><div class="form-group"><div class="checkbox-custom checkbox-default bk-margin-bottom-10"><input id="accept" name="accept" type="checkbox"/><label for="accept"> 确认需要部署的内容 <a href="form-wizard.html#">Terms of Service</a></label></div></div></div>'
	    	p.innerHTML = html;
	    }
	  });
	

}

function tab7() {
	alert('7');
	var options = {
        url:       'upload',         
        type:      'post'
    };

	$('#pkg').submit(function(event) {
		$(this).ajaxSubmit(options);
		return false;
	});
	alert('8');
}


function checkAll(checkid, divsid, check_name, div_name){
    var checklist = document.getElementsByName(check_name);
    var divlist = document.getElementsByName(div_name);
    var divsall = document.getElementById(divsid);
    if(document.getElementById(checkid).checked)
        {
        	divsall.setAttribute("class","checkbox-custom checkbox-danger");
        for(var i=0;i<checklist.length;i++)
        {
          checklist[i].checked = 1;
          divlist[i].setAttribute("class","checkbox-custom checkbox-danger");
          //checklist[i].setAttribute("class","checkbox-danger");
        }
    }else{
    	divsall.setAttribute("class","checkbox-custom checkbox-default");
        for(var j=0;j<checklist.length;j++)
        {
         checklist[j].checked = 0;
         divlist[j].setAttribute("class","checkbox-custom checkbox-default");
        }
    }
}


function checkOne(checkid,divid){
    var check = document.getElementById(checkid);
    var div = document.getElementById(divid);
    if(check.checked)
        {
        div.setAttribute("class","checkbox-custom checkbox-danger");
    }else{
    	div.setAttribute("class","checkbox-custom checkbox-default");
    }
}