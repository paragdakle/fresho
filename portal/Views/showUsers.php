				<div class="col-sm-3 settings-option-box">
					<ul class="nav nav-pills nav-stacked">
						<li ng-click="showUsers()" class="active"><a href="#">Users</a></li>
						<li ng-click="showOrders()"><a href="#">Orders</a></li>
						<li ng-click="showVendors()"><a href="#">Vendors</a></li>
						<li ng-click="showFruits()"><a href="#">Fruits</a></li>
						<li ng-click="showJuices()"><a href="#">Juices</a></li>
						<li ng-click="showSalads()"><a href="#">Salads</a></li>
						<li ng-click="showNutrients()"><a href="#">Nutrients</a></li>
						<li ng-click="showSatistics()"><a href="#">Statistics</a></li>
					</ul>
				</div>
				<div class="col-sm-9 settings-detail-box" style="padding-left: 0px;" ng-cloak>
				
					<input id="add-checkbox" type="checkbox" ng-model="addoption" style="opacity:0;"/>
					<label for="add-checkbox" ng-hide="addoption"><a><span class="glyphicon glyphicon-plus"></span></a> Add {{currentTab}}</label>
					<label for="add-checkbox" ng-show="addoption" class="pull-right"><span class="glyphicon glyphicon-remove"></span> Cancel</label>
					
					<div class="item-list-table" ng-hide="addoption" style="margin-left: 15px; margin-top: 10px;">
						<table class="table table-bordered" style="margin-bottom: 0px;">
							<thead>
								<tr>
									<th>Username</th>
									<th>Name</th>
									<th>Mobile No.</th>
									<th>Area</th>
									<th>Last Online</th>
									<th>Total Orders</th>
									<th>Total Billing</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="item in table_items | orderBy : 'name'">
									<td>{{ item.username}}</td>
									<td>{{ item.name}}</td>
									<td>{{ item.mobile_number}}</td>
									<td>{{ item.area}}</td>
									<td>{{ item.last_login}}</td>
									<td>{{ item.total_order_count}}</td>
									<td>{{ item.total_order_cost}}</td>
								</tr>
							</tbody>
						</table>
					
						<table class="table table-bordered">
							<tr ng-show="!table_items">
								<td>No records found</td>
							</tr>
						</table>
					</div>
					
					<form role="form" style="margin-left: 20px; margin-top: 10px;" name="profileForm" ng-show="addoption">
					  <div class="form-group">
					    <div class="col-sm-10" style="padding-left: 0px; margin-bottom: 15px;">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" ng-model="name">
							<span style="color:red" ng-show="profileForm.name.$dirty && profileForm.name.$invalid">
								<!--<span ng-show="profileForm.name.$error.required">Username is required.</span>-->
							</span>
						</div>
						<div class="col-sm-2" style="padding: 0px; margin-bottom: 15px;">
						  <label for="role">Role (select one):</label>
						  <select class="form-control" id="role" name="role" ng-model="role">
							<option value="admin">admin</option>
							<option value="user" selected>user</option>
						  </select>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-6" style="padding-left: 0px; margin-bottom: 15px;">
							<label for="mob_number">Mobile Number</label>
							<input type="text" class="form-control" id="mob_number" name="mob_number" placeholder="Enter your mobile number" ng-model="mob_number">
							<span style="color:red" ng-show="profileForm.mob_number.$dirty && profileForm.mob_number.$invalid">
								<!--<span ng-show="profileForm.mob_number.$error.required">Username is required.</span>-->
							</span>
						</div>
						<div class="col-sm-6" style="padding: 0px; margin-bottom: 15px;">
							<label for="email">Email address</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" ng-model="email">
							<span style="color:red" ng-show="profileForm.email.$dirty && profileForm.email.$invalid">
								<!--<span ng-show="profileForm.email.$error.required">Password is required.</span>-->
							</span>
						</div>
					  </div>
					  <div class="form-group">
						<label for="address">Address</label>
						<input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" ng-model="address">
						<span style="color:red" ng-show="profileForm.address.$dirty && profileForm.address.$invalid">
							<!--<span ng-show="profileForm.address.$error.required">Password is required.</span>-->
						</span>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-6" style="padding-left: 0px">
							<label for="area">Area</label>
							<input type="text" class="form-control" id="area" name="area" placeholder="Enter your area" ng-model="area">
							<span style="color:red" ng-show="profileForm.area.$dirty && profileForm.area.$invalid">
								<!--<span ng-show="profileForm.area.$error.required">Password is required.</span>-->
							</span>
						</div>
						<div class="col-sm-6" style="padding: 0px">
							<label for="city">City</label>
							<input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" ng-model="city">
							<span style="color:red" ng-show="profileForm.city.$dirty && profileForm.city.$invalid">
								<!--<span ng-show="profileForm.city.$error.required">Password is required.</span>-->
							</span>
						</div>
					  </div>
					  <div class="form-group">
					    <div class="col-sm-6" style="padding-left: 0px; margin: 15px 0px;">
							<label for="state">State</label>
							<input type="text" class="form-control" id="state" name="state" placeholder="Enter your state" ng-model="state">
							<span style="color:red" ng-show="profileForm.state.$dirty && profileForm.state.$invalid">
								<!--<span ng-show="profileForm.state.$error.required">Password is required.</span>-->
							</span>
						</div>
						<div class="col-sm-6" style="padding: 0px; margin: 15px 0px;">
							<label for="country">Country</label>
							<input type="text" class="form-control" id="country" name="country" placeholder="Enter your country" ng-model="country">
							<span style="color:red" ng-show="profileForm.country.$dirty && profileForm.country.$invalid">
								<!--<span ng-show="profileForm.country.$error.required">Password is required.</span>-->
							</span>
						</div>
					  </div>
					  <button type="submit" class="btn btn-primary" ng-click="adduser()">Add</button>
					</form>
				</div>