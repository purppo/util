	<div class="col-sm-3 col-md-2 sidebar">
		<ul class="nav nav-sidebar navbar-collapse collapse">
			<!----search---->
			<ul class="nav-area">
				<li>
					<div class="nav-area-title">Util</div>
					<ul>
						<li {if $file_name=="index"}class="active"{/if}><a href="index.php">Source Code Highlight</a></li>
						<li {if $file_name=="url"}class="active"{/if}><a href="url.php">Url En/De coding</a></li>
						<li {if $file_name=="json"}class="active"{/if}><a href="json.php">Json En/De coding</a></li>
						<!-- <li {if $file_name=="preg"}class="active"{/if}><a href="preg.php">Preg</a></li> -->
						<li {if $file_name=="ip"}class="active"{/if}><a href="ip.php">Ip</a></li>
						<li {if $file_name=="curl"}class="active"{/if}><a href="curl.php">Curl</a></li>
					</ul>
				</li>
			</ul>

			<ul class="nav-competition">
				<li>
					<div class="nav-competition-title">Other</div>
					<ul>
						<li><a href="https://github.com/purppo" target="_blank">​Purppo</a></li>
					</ul>
				</li>
			</ul>			
		</ul>
	</div>