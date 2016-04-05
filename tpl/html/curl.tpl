<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" href="./common/img/ico/favicon.ico">
	
    <title>Curl</title>

    <!-- bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- originalbase -->
    <link href="./common/css/common.css" rel="stylesheet">
    <link href="../common/css/ui.css" rel="stylesheet">
	<link href="../common/css/select2/select2.min.css" rel="stylesheet" />
	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <style type="text/css">
    .group:first-child .delete { display: none; }
  </style>
  </head>

  <body>
    <div id="header">
		&nbsp;
    </div>

    {include file="./main_header.tpl"}
		<div class="row">
			{include file="./main_menu.tpl"}
			
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header page-header-relative">
                <div>Curl</div>
            </h1>
		
			<div>
				<form role="form" method="post">
					<div class="row">
					  <div class="col-sm-2">
					    <label>url : </label>
					  </div>
  					<div class="col-sm-6">
              <input type="text" class="form-control" id="form1-1" name="url" value="{$url}">
            </div>
  					<div class="col-sm-4">
  						<select name="type" class="select_search form-control input-sm">
  							{foreach from=$type_list key=k item=v}
  								<option value="{$v}" {if $params.type == $v} selected {/if}>{$v}</option>
  							{/foreach}}
  						</select>
  					</div>
					</div>
					</br>
					</br>
					</br>
					<div class="row">
					
					{if count($params['list']) > 0}
  					{foreach from=$params['list'] key=key item=val name=foo}
              
                <div class="group">
                  <div class="form-group">
                    <div class="col-sm-2">
                      <label for="form1-1">{$smarty.foreach.foo.iteration}</label>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="form1-1" name="list[{$key}][name]" value="{$val.name}">
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="form1-1" name="list[{$key}][value]" value="{$val.value}">
                    </div>
                    <div class="col-sm-3">
                      <button class="btn btn-default add" type="button"><i class="fa fa-plus"></i></button>
                      <button class="btn btn-sm btn-default delete" type="button"><i class="fa fa-minus"></i></button>
                    </div>
                  </div>  
                </div><!-- group -->
              
            {/foreach}
          {else}
              <div class="group">
                <div class="form-group">
                  <div class="col-sm-2">
                    <label for="form1-1">1</label>
                  </div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="form1-1" name="list[0][name]" style="width:300px">
                  </div>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" id="form1-2" name="list[0][value]" style="width:300px">
                  </div>
                  <div class="col-sm-3">
                    <button class="btn btn-default add" type="button"><i class="fa fa-plus"></i></button>
                    <button class="btn btn-sm btn-default delete" type="button"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
              </div><!-- group -->
          {/if}
          
          </br>
          </br>
          </br>
          </br>
          </br>
					<div class="col-sm-12">
						<button class="btn btn-sm btn-warning btn-block" type="submit">exec</button>
					</div>
				</form>
			</div>
			</div>
			<div class="row">
			    {$html}
			</div>
    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {*
      {include file="secure/analytics.tpl"}   
    *}
    
    <script src="../common/js/jquery-2.1.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../common/js/select2/select2.min.js"></script>
	{literal}
	<script type="text/javascript">
		$(".select_search").select2();
		
		 $(function () {
      var planCount = 0;
  
      $('.group').on('click', '.add', function (e) {
        var $plusButton = $(this);
        var $planGroup = $plusButton.parents('.group');
  
        add($planGroup);
      });
  
      $('.group').on('click', '.delete', function (e) {
        var $minusButton = $(this);
        var $planGroup = $minusButton.parents('.group');
  
        $planGroup.remove();
        setAttr();
      });
  
      function add($target) {
        var $clone = $target.clone(true);
  
        $clone.find('[type="text"]').val('');
        $clone.insertAfter($target);
  
        setAttr();
      };
  
      function setAttr() {
        var $list = $('.group');
  
        $.map($list, function (e, i) {
          var id = '' + (i+1);
          var name = 'list[' + i + '][name]';
          var value = 'list[' + i + '][value]';
  
          $(e).find('label').text(id);
          $(e).find('#form1-1').attr('name', name);
          $(e).find('#form1-2').attr('name', value);
        })
      }
    });
		
	</script>
	{/literal}
  </body>
</html>
<strong></strong>
