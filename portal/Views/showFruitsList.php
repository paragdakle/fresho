		  <ul class="nav nav-tabs">
			<li class="active"><a href="#">Browse by Fruits</a></li>
			<li><a href="#">Browse by Juices</a></li>
			<li><a href="#">Browse by Salads</a></li>
			<li><a href="#">Browse by Nutrients</a></li>
		  </ul>
		  <div class="row">
			<div class="col-md-4" ng-repeat="item in table_items | orderBy : 'name'">
			  <div class="item-details">
				<img src="resources/images/fresh-fruit-high-resolution-background-1680x1050.jpg" class="img-thumbnail" alt="Kiwi">
				<dl>
					<dt></dt>
					<dd></dd>
					<dd></dd>
					<dd></dd>
				</dl>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="item-details">
				<img src="resources/images/fruits-watermelon-free-hd-wallpapers-1680x1050.jpeg" class="img-thumbnail" alt="Watermelon">
			  </div>
			</div>
			<div class="col-md-4"> 
			  <div class="item-details">
				<img src="resources/images/Background-hd-Mango-Wallpaper-Download.jpg" class="img-thumbnail" alt="mango">
			  </div>
			</div>
		  </div>