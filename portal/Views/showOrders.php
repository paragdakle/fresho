				<div class="col-sm-3 settings-option-box">
					<ul class="nav nav-pills nav-stacked">
						<li ng-click="showUsers()"><a href="#">Users</a></li>
						<li ng-click="showOrders()" class="active"><a href="#">Orders</a></li>
						<li ng-click="showVendors()"><a href="#">Vendors</a></li>
						<li ng-click="showFruits()"><a href="#">Fruits</a></li>
						<li ng-click="showJuices()"><a href="#">Juices</a></li>
						<li ng-click="showSalads()"><a href="#">Salads</a></li>
						<li ng-click="showNutrients()"><a href="#">Nutrients</a></li>
						<li ng-click="showSatistics()"><a href="#">Statistics</a></li>
					</ul>
				</div>
				<div class="col-sm-9 settings-detail-box" style="padding-left: 0px;" ng-cloak>
					
					<div class="item-list-table" style="margin-left: 15px; margin-top: 10px;">
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
				</div>