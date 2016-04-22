<div ng-cloak data-ui-block="members" ng-controller="ListMembers">

	<div ng-repeat="item in todos">

		<div data-ui-block="member" ng-click="go(item.id)">

			<div class="avatar avatar-2x" style="background-image: url('http://volya.ua/s/img/thumb/ai/{{ item.avatar }} ');">
				<i ng-if="item.avatar == ''" class="icon icon-user"></i>
			</div>

			<div class="name" style="">
				<b>{{ item.last_name }}</b><br />
				{{ item.first_name }} {{ item.middle_name }}
			</div>
			<div class="cboth"></div>

		</div>

	</div>

</div>