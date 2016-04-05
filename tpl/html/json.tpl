<!DOCTYPE html>
<html lang="jp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" href="./common/img/ico/favicon.ico">
	
    <title>json En/De coding</title>

    <!-- bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- originalbase -->
    <link href="./common/css/common.css" rel="stylesheet">
    <link href="../common/css/ui.css" rel="stylesheet">
	<link href="../common/css/select2/select2.min.css" rel="stylesheet" />
    
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
                <div>source En/De coding</div>
            </h1>
		
			<div>
				<form role="form" method="post">
					<textarea name="source" class="form-control" rows="10">{$params.source}</textarea>
					</br>
					
					<div class="col-sm-6">
						<select name="type" class="select_search form-control input-sm">
							{foreach from=$type_list key=k item=v}
								<option value="{$v}" {if $params.type == $v} selected {/if}>{$v}</option>
							{/foreach}}
						</select>
					</div>
					
					<div class="col-sm-6">
						<button class="btn btn-sm btn-warning btn-block" type="submit">Convert</button>
					</div>
				</form>
			</div>
			
			{if $params.source_convert != ''}
				</br></br>
				<div style="width: 100%">
					<pre>{$params.source_convert}</pre>
				</div>
			{/if}
			
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
	
	<script type="text/javascript">
		$(".select_search").select2();
	</script>
	
  </body>
</html>
<strong></strong>
