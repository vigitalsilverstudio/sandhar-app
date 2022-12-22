var sandhar = angular.module('SandHar', ['ui.router']);

//var url = 'http://localhost:8000';

url = 'http://wgs.usermd.net'; 
var api_url = url + '/api';

var users_page = 1;
var products_page = 1;
var users_products_page = 1;
var statistics_page = 1;
var users_statistics_page = 1;
var current_statistics_page = 1;
var current_users_statistics_page = 1;

ConvertUsersObject = function(users){
	
	for(n = 0; n < users.length; n++){
		if(users[n].active == true){
			users[n].active = 'Aktywne';
		}
		
		else{
			users[n].active = 'Nie aktywne';
		}		
		
		if(users[n].staff == true){
			users[n].staff = 'Tak';
		}
		
		else{
			users[n].staff = 'Nie';
		}
	}
	
	return users;
}

ConvertUserObject = function(user){
	
	
	if(user.active == true){
		user.active = '1';
	}
		
	else{
		user.active = '0';
	}		
		
	if(user.staff == true){
		user.staff = '1';
	}
		
	else{
		user.staff = '0';
	}
	
	return user;
}

sandhar.config(function($httpProvider, $urlRouterProvider, $stateProvider){	 
	
	$httpProvider.interceptors.push(function($q) {
		return {
			'request': function(config) {
				config.headers['Authorization'] = 'Bearer ' + localStorage.token;
				return config;
			}
		};
	});
  
	$urlRouterProvider.otherwise('/login');
	
	$stateProvider
	
		.state('login', {
            url: '/login',
            templateUrl: '/templates/login.html',
			controller: 'LoginController'
        })
		
		.state('logout', {
            url: '/logout',         
			controller: 'LogoutController'
        })
		
		.state('admin_users', {
			url: '/account/admin/users',
			templateUrl: '/templates/admin_users.html',
			controller: 'AdminUsersController',
			resolve: {
				promiseUsers:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/users?page=' + users_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}
		})
		
		.state('admin_products', {
			url: '/account/admin/products',
			templateUrl: '/templates/admin_products.html',
			controller: 'AdminProductsController',
			resolve: {
				promiseProducts:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/products?page=' + products_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}
		})
		
		.state('admin_users_products', {
			url: '/account/admin/users_products',
			templateUrl: '/templates/admin_users_products.html',
			controller: 'AdminUsersProductsController',
			resolve: {
				promiseUsersProducts:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/users_products?page=' + users_products_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}
		})
		
		.state('admin_statistics', {
			url: '/account/admin/statistics',
			templateUrl: '/templates/admin_statistics.html',
			controller: 'AdminStatisticsController',
			resolve: {
				promiseStatistics:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/statistics?page=' + statistics_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}		
		})
		
		.state('admin_user_statistics', {
			url: '/account/admin/user_statistics',
			templateUrl: '/templates/admin_user_statistics.html',
			controller: 'AdminUserStatisticsController',
			resolve: {
				promiseUserStatistics:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/user_statistics?page=' + users_statistics_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}		
		})
		
		.state('admin_current_statistics', {
			url: '/account/admin/current_statistics',
			templateUrl: '/templates/admin_current_statistics.html',
			controller: 'AdminCurrentStatisticsController',
			resolve: {
				promiseCurrentStatistics:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/current_statistics?page=' + current_statistics_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}			
		})
		
		.state('admin_current_user_statistics', {
			url: '/account/admin/current_user_statistics',
			templateUrl: '/templates/admin_current_user_statistics.html',
			controller: 'AdminCurrentUserStatisticsController',
			resolve: {
				promiseCurrentUserStatistics:
					function($http){
						
						if(localStorage.token != undefined){
							return $http.get(api_url + '/current_user_statistics?page=' + current_users_statistics_page);
						}
						
						else{
							$state.go('login');
						}
					}
			}
			
		})
		
		.state('user_workspace', {
			url: '/account/user/workspace',
			templateUrl: '/templates/account_user_workspace.html',
			controller: 'AccountUserWorkspaceController'			
		});
});

sandhar.run(function($transitions, $http, $state) {
	
  $transitions.onStart({}, function($transitions){
		
		if(localStorage.token == undefined){
			$state.go('login');			
			return true;
		}
		
		if($transitions.$to().name.includes('admin')){
			$http.post(api_url + '/auth',{}).then(
				function success(response){
					user = response.data.data.user;
					
					if(!((user.staff && user.active) || user.superuser)){						
						$state.go('login');
						return true;						
					}
				}
			);
		}
		
		if($transitions.$to().name.includes('user')){
			$http.post(api_url + '/auth',{}).then(
				function success(response){
					user = response.data.data.user;
					
					if(!user.active){						
						$state.go('login');						
					}
				}
			);
		}
	});
	
});

sandhar.controller('LoginController', function($scope, $http, $state){
	
	$scope.login_data = {
		'username': '',
		'password': '',
		'staff': '0'
	};
	
	$scope.LoginMe = function(){
		
		$http.post(api_url + '/login', $scope.login_data).then(
			function(response){
				if(response.data.success == true){
					localStorage.username = $scope.login_data['username'];
					localStorage.token = response.data.data.token;
					localStorage.staff = $scope.login_data['staff'];
					
					$scope.server_messages_error = '';
					
					if($scope.login_data.staff == '0'){
						$state.go('user_workspace');
					}
					
					else if($scope.login_data.staff == '1'){
						$state.go('admin_current_user_statistics');
					}
				}
				
				else{
					$scope.server_messages_error = response.data.errors;					
				}
			}
		);
	}
	
});

sandhar.controller('LogoutController', function($scope, $state){
	localStorage.clear();
	$state.go('login');
});

sandhar.controller('AdminUsersController', function($scope, $http, promiseUsers){
	var users = promiseUsers.data.data.users.data;
	$scope.users = ConvertUsersObject(users);
	
	current_page = promiseUsers.data.data.users;
		
	$scope.search_field = 'first_name';
	
	$scope.CloseShowUserDialog = function(){
		jQuery('#show_user').modal('hide');		
	}
	
	$scope.CloseDeleteUserDialog = function(){		
		jQuery('#delete_user').modal('hide');		
	}
	
	$scope.CloseEditUserDialog = function(){		
		jQuery('#edit_user').modal('hide');		
	}
	
	$scope.CloseCreateUserDialog = function(){		
		jQuery('#create_user').modal('hide');		
	}
	
	$scope.SearchUsers = function(){
		jQuery('#search_user').modal('show');
	}
	
	$scope.searchUserEngine = function($event){
		
		if($scope.search == undefined){
			return;
		}
		
		$http.get(api_url + '/users').then(
			function(response){
				if(response.data.success == true){
										
					$scope.users = response.data.data.users;
					
					if($scope.search_field == 'first_name'){
						$scope.users = ConvertUsersObject($scope.users.filter(function(user){ return (user.first_name.startsWith($scope.search))}));
					}
					
					if($scope.search_field == 'last_name'){
						$scope.users = ConvertUsersObject($scope.users.filter(function(user){ return (user.last_name.startsWith($scope.search))}));						
					}
					
					if($scope.search_field == 'email'){
						$scope.users = ConvertUsersObject($scope.users.filter(function(user){ return (user.email.startsWith($scope.search))}));
					}
					
					if($scope.search_field == 'active'){
						if($scope.search == '1' || $scope.search == '0')
							$scope.users = ConvertUsersObject($scope.users.filter(function(user){ return (user.active == parseInt($scope.search)) }));
						else
							return;
					}
					
					if($scope.search_field == 'staff'){
						if($scope.search == '1' || $scope.search == '0')
							$scope.users = ConvertUsersObject($scope.users.filter(function(user){ return (user.staff == parseInt($scope.search)) }));
						else
							return;
					}
					
					if($scope.search_field == 'username'){
						$scope.users = ConvertUsersObject($scope.users.filter(function(user){ return (user.username.startsWith($scope.search))}));
					}
					
					
					if($scope.search == ''){
						$http.get(api_url + '/users?page=' + users_page).then(
							function(response){
								$scope.users = ConvertUsersObject(response.data.data.users.data);
							}
						);
					}
					
				}
			}
		);
	}
	
	$scope.ShowUserDialog = function(username){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
			
		$http.get(api_url + '/users/' + username).then(
			function(response){
				
				if(response.data.success == true){					
					$scope.user = response.data.data.user;					
					$scope.user = ConvertUserObject($scope.user);													
										
					jQuery('#show_user').modal('show');					
				}
				
				else{
					$scope.server_messages_error = response.data.errors;
				}
			}
		);
	}
	
	$scope.ShowDeleteUserDialog = function(username){		
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$http.get(api_url + '/users/' + username).then(
			function(response){
				
				if(response.data.success == true){
					user = response.data.data.user;					
										
					$scope.user = response.data.data.user;										
					$scope.user = ConvertUserObject($scope.user);
					
					jQuery('#delete_user').modal('show');					
				}				
			}
		);
	}
	
	$scope.DeleteUserAccount = function(username){
			
		$http.delete(api_url + '/users/' + username).then(
			function(response){
					
				$scope.CloseDeleteUserDialog();
					
				if(response.data.success == true){					
					$scope.server_messages = ['Konto zostało usunięte'];
						
					$http.get(api_url + '/users?page=' + users_page).then(
						function(response){
							if(response.data.success == true){
								$scope.users = ConvertUsersObject(response.data.data.users.data);
								
							}
					});
				}
					
				else{
					$scope.server_messages_error = response.data.errors;
				}
			}
		);
	}
	
	$scope.ShowEditUserDialog = function(username){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$http.get(api_url + '/users/' + username).then(
			function(response){
				
				if(response.data.success == true){
					
					$scope.user = response.data.data.user;					
					$scope.data = jQuery.extend({},$scope.user);
					
					$scope.data = ConvertUserObject($scope.data);
										
					jQuery('#edit_user').modal('show');					
				}				
			}
		);
	}
	
	$scope.EditUserAccount = function(username){
		
		$http.put(api_url + '/users/' + username, $scope.data).then(
			function(response){
				
				if(response.data.success == true){					
					$scope.server_messages = ['Konto zostało edytowane'];
					
					$http.get(api_url + '/users?page=' + users_page).then(
						function(response){
							if(response.data.success == true){
								$scope.users = ConvertUsersObject(response.data.data.users.data);
							}
					});
					
					$scope.CloseEditUserDialog();
				}
					
				else{
						
					if(response.data.errors[0].includes('user_staff')){
						
						response.data.errors = response.data.errors.slice(1);
						$scope.server_messages_error = response.data.errors;
						
						$scope.CloseEditUserDialog();
					}
					
					else{
						$scope.server_validation_error_messages = response.data.errors;
					}
					
					
				}
			}
		);
	}
	
	$scope.ShowCreateUserDialog = function(username){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$scope.data = {
			'first_name': '',
			'last_name': '',
			'email': '',
			'password': '',
			'active': '1',
			'staff': '0',
		}
		
		jQuery('#create_user').modal('show');		
	}
	
	$scope.CreateUserAccount = function(){
		
		$http.post(api_url + '/users', $scope.data).then(
			function(response){
				if(response.data.success == true){					
					$scope.server_messages = ['Konto zostało utworzone'];
					
					$http.get(api_url + '/users?page=' + users_page).then(
						function(response){
							if(response.data.success == true){
								$scope.users = ConvertUsersObject(response.data.data.users.data);
								current_page = response.data.data.users;
								
							}
					});
					
					$scope.CloseCreateUserDialog();
				}
					
				else{
						
					if(response.data.errors[0].includes('user_found')){
						
						response.data.errors = response.data.errors.slice(1);
						$scope.server_messages_error = response.data.errors;
						
						$scope.CloseCreateUserDialog();
					}
					
					else{
						$scope.server_validation_error_messages = response.data.errors;
					}
					
					
				}
			}
		);		
	}
	
	$scope.SaveUsers = function(){
		$http.post(api_url + '/users/save',{}, {responseType: 'arraybuffer'}).then(
			function(response){
				
                var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
                saveAs(blob, 'Użytkownicy' + ".xlsx");
			}
		);
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/users?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.users = ConvertUsersObject(response.data.data.users.data);
					
					current_page = response.data.data.users;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/users?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.users = ConvertUsersObject(response.data.data.users.data);
					
					current_page = response.data.data.users;					
				}
			}
		);
	}
	
	
});

sandhar.controller('AdminProductsController', function($scope, $http, promiseProducts){
	
	$scope.products = promiseProducts.data.data.products.data;
	
	current_page = promiseProducts.data.data.products;
	
	$scope.search_field = 'product_id';
	
	$scope.CloseShowProductDialog = function(){
		jQuery('#show_product').modal('hide');		
	}
	
	$scope.CloseDeleteProductDialog = function(){		
		jQuery('#delete_product').modal('hide');		
	}
	
	$scope.CloseEditProductDialog = function(){		
		jQuery('#edit_product').modal('hide');		
	}
	
	$scope.CloseCreateProductDialog = function(){		
		jQuery('#create_product').modal('hide');		
	}
	
	$scope.SearchProducts = function(){
		jQuery('#search_product').modal('show');
	}
	
	$scope.searchProductEngine = function(event){
		
		if($scope.search == undefined){
			return;
		}
		
		$http.get(api_url + '/products').then(
			function success(response){
				$scope.products = response.data.data.products;
					
		
					
					if($scope.search_field == 'product_id'){
						$scope.products = $scope.products.filter(function(product){ return (product.product_id.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'product_name'){
						$scope.products = $scope.products.filter(function(product){ return (product.product_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'company_name'){
						$scope.products = $scope.products.filter(function(product){ return (product.company_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'min_production_level'){
						$scope.products = $scope.products.filter(function(product){ return (String(product.min_production_level).startsWith($scope.search))});																	
					}
					
					if($scope.search == ''){
						$http.get(api_url + '/products?page=' + products_page).then(
							function(response){
								$scope.products = response.data.data.products.data;
							}
						);
					}
			}
		);
	}
	
	$scope.ShowProductDialog = function(product_id){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
			
		$http.get(api_url + '/products/' + product_id).then(
			function(response){
				
				if(response.data.success == true){					
					$scope.product = response.data.data.product;									
					jQuery('#show_product').modal('show');					
				}
				
				else{
					$scope.server_messages_error = response.data.errors;
				}
			}
		);
	}
	
	$scope.ShowDeleteProductDialog = function(product_id){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
			
		$http.get(api_url + '/products/' + product_id).then(
			function(response){
				
				if(response.data.success == true){					
					$scope.product = response.data.data.product;										
					jQuery('#delete_product').modal('show');
				}
				
				else{
					$scope.server_messages_error = response.data.errors;
				}
			}
		);
	}
	
	$scope.DeleteProduct = function(product_id){
		
		$http.delete(api_url + '/products/' + product_id).then(
			function(response){
				
				$scope.CloseDeleteProductDialog();
				
				if(response.data.success == true){
					$scope.server_messages = ['Produkt zostało usunięty'];
						
					$http.get(api_url + '/products?page=' + products_page).then(
						function(response){
							if(response.data.success == true){
								$scope.products = response.data.data.products.data;
								
							}
					});
				}
				
				else{
					$scope.server_messages_error = response.data.errors;
				}
			}
		);
	}
	
	$scope.ShowEditProductDialog = function(product_id){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$http.get(api_url + '/products/' + product_id).then(
			function(response){
				
				if(response.data.success == true){					
					$scope.product = response.data.data.product;
					$scope.data = jQuery.extend({},$scope.product);
					
					jQuery('#edit_product').modal('show');
				}
				
				else{
					$scope.server_messages_error = response.data.errors;
				}
			}
		);	
	}	
	
	$scope.EditProduct = function(product_id){
		
		$http.put(api_url + '/products/' + product_id, $scope.data).then(
			function(response){
				if(response.data.success == true){
					$scope.server_messages = ['Produkt został edytowany'];
					
					$scope.CloseEditProductDialog();
					
					$http.get(api_url + '/products?page=' + products_page).then(
						function(response){
							if(response.data.success == true){
								$scope.products = response.data.data.products.data;
							}
						}					
					);	
				}				
				
				else{
					if(response.data.errors[0].includes('product_not_found')){																	
						response.data.errors = response.data.errors.slice(1);
						$scope.server_messages_error = response.data.errors;
						
						$scope.CloseCreateUserDialog();
					}
					
					else{
						$scope.server_validation_error_messages = response.data.errors;
					}					
				}
			}				
		);
	}
	
	$scope.ShowCreateProductDialog = function(){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$scope.data = {
			'product_id': '',
			'product_name': '',
			'company_name': 'autoliv',
			'min_production_level': 0
		}
		jQuery('#create_product').modal('show');
	}
	
	$scope.CreateProduct = function(){
				
		$http.post(api_url + '/products', $scope.data).then(
			function(response){
								
				if(response.data.success == true){					
					$scope.server_messages = ['Produkt został utworzony'];
					
					$scope.CloseCreateProductDialog();
					
					$http.get(api_url + '/products?page=' + products_page).then(
						function(response){
							if(response.data.success == true){
								$scope.products = response.data.data.products.data;
								current_page = response.data.data.users_products; 
								
							}
					});
					
					$scope.CloseCreateProductDialog();
				}
					
				else{
						
					if(response.data.errors[0].includes('product_found')){
						
						response.data.errors = response.data.errors.slice(1);
						$scope.server_messages_error = response.data.errors;
						
						$scope.CloseCreateProductDialog();
					}
					
					else{
						$scope.server_validation_error_messages = response.data.errors;
					}
					
					
				}
			}			
		);
	}
	
	$scope.SaveProducts = function(){
		$http.post(api_url + '/products/save',{}, {responseType: 'arraybuffer'}).then(
			function(response){
				
                var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
                saveAs(blob, 'Produkty' + ".xlsx");
			}
		);
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/products?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.products = response.data.data.products.data;
					
					current_page = response.data.data.products;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/products?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.products = response.data.data.products.data;
					
					current_page = response.data.data.products;					
				}
			}
		);
	}
});


sandhar.controller('AdminUsersProductsController', function($scope, $http, promiseUsersProducts){	
	
	$scope.users_products = promiseUsersProducts.data.data.users_products.data;
	current_page = promiseUsersProducts.data.data.users_products;
	
	$scope.search_field = 'product_id';
	
	$scope.CloseShowUserProductDialog = function(){
		jQuery('#show_user_product').modal('hide');		
	}
	
	$scope.CloseDeleteUserProductDialog = function(){		
		jQuery('#delete_user_product').modal('hide');		
	}
	
	$scope.CloseEditUserProductDialog = function(){		
		jQuery('#edit_user_product').modal('hide');		
	}
	
	$scope.CloseCreateUserProductDialog = function(){		
		jQuery('#create_user_product').modal('hide');		
	}
	
	$scope.SearchUserProducts = function(){
		jQuery('#search_user_product').modal('show');
	}
	
	$scope.searchUserProductEngine = function(event){
		
		if($scope.search == undefined){
			return;
		}
		
		$http.get(api_url + '/users_products').then(
			function success(response){
					$scope.users_products = response.data.data.users_products;
					
					if($scope.search_field == 'product_id'){
						$scope.users_products = $scope.users_products.filter(function(product){ return (product.product_id.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'product_name'){
						$scope.users_products = $scope.users_products.filter(function(product){ return (product.product_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'company_name'){
						$scope.users_products = $scope.users_products.filter(function(product){ return (product.company_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'min_production_level'){
						$scope.users_products = $scope.users_products.filter(function(product){ return (String(product.min_production_level).startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'username'){
						$scope.users_products = $scope.users_products.filter(function(product){ return (String(product.username).startsWith($scope.search))});																	
					}
					
					if($scope.search == ''){
						$http.get(api_url + '/users_products?page=' + users_products_page).then(
							function(response){
								$scope.users_products = response.data.data.users_products.data;
							}
						);
					}
			}
		);
	}
	
	$scope.ShowUserProductDialog = function(product_id, login){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$http.get(api_url + '/users_products/' + product_id + '/' + login).then(
			function(response){
				if(response.data.success == true){
					$scope.user_product = response.data.data.user_product;
					jQuery('#show_user_product').modal('show');
				}
			}
		);
	}
	
	$scope.ShowDeleteUserProductDialog = function(product_id, login){		
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		$http.get(api_url + '/users_products/' + product_id + '/' + login).then(
			function(response){
				if(response.data.success == true){
					$scope.user_product = response.data.data.user_product;
					jQuery('#delete_user_product').modal('show');
				}
			}
		);
	}
	
	$scope.DeleteUserProduct = function(product_id, login){
		$http.delete(api_url + '/users_products/' + product_id + '/' + login).then(
			function(response){
				
				$scope.CloseDeleteUserProductDialog();
				
				if(response.data.success == true){
					$scope.server_messages = ['Produkt użytkownika został usunięty'];
						
					$http.get(api_url + '/users_products?page=' + users_products_page).then(
						function(response){
							if(response.data.success == true){
								$scope.users_products = response.data.data.users_products.data;								
							}
					});
				}
			}
		);
	}
	
	$scope.ShowCreateUserProductDialog = function(product_id, login){
		$scope.server_messages = '';
		$scope.server_messages_error = '';
		$scope.server_validation_error_messages = '';
		
		jQuery('#create_user_product').modal('show');
	}
	
	$scope.CreateUserProduct = function(){
		$http.post(api_url + '/users_products', $scope.data).then(
			function(response){
				if(response.data.success == true){					
					$scope.server_messages = ['Produkt użytkownika został utworzony'];
					
					$scope.CloseCreateUserProductDialog();
					
					$http.get(api_url + '/users_products?page=' + users_products_page).then(
						function(response){
							if(response.data.success == true){
								$scope.users_products = response.data.data.users_products.data;
								current_page = response.data.data.users_products;
								
							}
					});
				}
					
				else{
						
					if(response.data.errors[0].includes('no_validation_error')){
						
						response.data.errors = response.data.errors.slice(1);
						$scope.server_messages_error = response.data.errors;
						
						$scope.CloseCreateUserProductDialog();
					}
					
					else{
						$scope.server_validation_error_messages = response.data.errors;
					}
					
					
				}					
			}
		);
	}
	
	$scope.SaveUsersProducts = function(){
		$http.post(api_url + '/users_products/save',{}, {responseType: 'arraybuffer'}).then(
			function(response){
				
                var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
                saveAs(blob, 'Produkty użytkownika' + ".xlsx");
			}
		);
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/users_products?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.users_products = response.data.data.users_products.data;
					
					current_page = response.data.data.users_products;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/users_products?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.users_products = response.data.data.users_products.data;
					
					current_page = response.data.data.users_products;					
				}
			}
		);
	}
	
});

sandhar.controller('AdminStatisticsController', function($scope, $http, promiseStatistics){
	$scope.statistics = promiseStatistics.data.data.statistics.data;
	current_page = promiseStatistics.data.data.statistics;
	
	$scope.search_field = 'product_id';
	
	$scope.CloseShowStatisticDialog = function(){
		jQuery('#show_statistic').modal('hide');		
	}
	
	$scope.SearchStatistics = function(){
		jQuery('#search_statistic').modal('show');
	}
	
	$scope.searchStatisticEngine = function(event){
		
		if($scope.search == undefined){
			return;
		}
		
		$http.get(api_url + '/statistics/').then(
			function success(response){
				$scope.statistics = response.data.data.statistics;
					
					if($scope.search_field == 'product_id'){
						$scope.statistics = $scope.statistics.filter(function(product){ return (product.product_id.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'product_name'){
						$scope.statistics = $scope.statistics.filter(function(product){ return (product.product_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'company_name'){
						$scope.statistics = $scope.statistics.filter(function(product){ return (product.company_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'min_production_level'){
						$scope.statistics = $scope.statistics.filter(function(product){ return (String(product.min_production_level).startsWith($scope.search))});																	
					}
					
					if($scope.search == ''){
						$http.get(api_url + '/statistics?page=' + statistics_page).then(
							function(response){
								$scope.statistics = response.data.data.statisitcs.data;
							}
						);
					}
			}
		);
	}
	
	$scope.ShowStatisticDialog = function(product_id, id){
		
		$http.get(api_url + '/statistics/' + product_id + '/' + id).then(
			function(response){
				if(response.data.success == true){
					$scope.statistic = response.data.data.statistic;
					
					jQuery('#show_statistic').modal('show');
				}
			}
		);
	}
	
	$scope.SaveStatistics = function(){
		$http.post(api_url + '/statistics/save/autoliv',{}, {responseType: 'arraybuffer'}).then(
			function(response){
				
                var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
                saveAs(blob, 'Statystyki Autoliv' + ".xlsx");
				
				$http.post(api_url + '/statistics/save/trw',{}, {responseType: 'arraybuffer'}).then(
					function(response){
				
						var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
						saveAs(blob, 'Statystyki Trw' + ".xlsx");
					}
				);
			}
		);	
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.statistics = response.data.data.statistics.data;
					
					current_page = response.data.data.statistics;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.statistics = response.data.data.statistics.data;
					
					current_page = response.data.data.statistics;			
				}
			}
		);
	}
	
});

sandhar.controller('AdminUserStatisticsController', function($scope, $http, promiseUserStatistics){
	$scope.user_statistics = promiseUserStatistics.data.data.user_statistics.data;
	
	current_page = promiseUserStatistics.data.data.user_statistics;
	
	$scope.search_field = 'product_id';
	
	$scope.CloseShowUserStatisticDialog = function(){
		jQuery('#show_user_statistic').modal('hide');		
	}
	
	$scope.SearchUsersStatistics = function(){
		jQuery('#search_user_statistic').modal('show');
	}
	
	$scope.searchUserStatisticEngine = function(event){
			
		if($scope.search == undefined){
			return;
		}
			
		$http.get(api_url + '/user_statistics/').then(
			function success(response){
				$scope.user_statistics = response.data.data.user_statistics;

					
					if($scope.search_field == 'product_id'){
						$scope.user_statistics = $scope.user_statistics.filter(function(product){ return (product.product_id.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'product_name'){
						$scope.user_statistics = $scope.user_statistics.filter(function(product){ return (product.product_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'company_name'){
						$scope.user_statistics = $scope.user_statistics.filter(function(product){ return (product.company_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'min_production_level'){
						$scope.user_statistics = $scope.user_statistics.filter(function(product){ return (String(product.min_production_level).startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'username'){
						$scope.user_statistics = $scope.user_statistics.filter(function(product){ return (String(product.username).startsWith($scope.search))});
					}		
					
					if($scope.search == ''){
						$http.get(api_url + '/user_statistics?page=' + users_statistics_page).then(
							function(response){
								$scope.user_statistics = response.data.data.user_statistics.data;
							}
						);
					}
			}
		);
	}
	
	$scope.ShowUserStatisticDialog = function(product_id, login, id){
		$http.get(api_url + '/user_statistics/' + product_id + '/' + login + '/' + id).then(
			function(response){
				if(response.data.success == true){
					$scope.user_statistic = response.data.data.user_statistic;
					
					jQuery('#show_user_statistic').modal('show');
				}
			}
		);
	}
	
	$scope.SaveUserStatistics = function(){
		$http.post(api_url + '/user_statistics/save/autoliv',{}, {responseType: 'arraybuffer'}).then(
			function(response){
				
                var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
                saveAs(blob, 'Statystyki użytkownika Autoliv' + ".xlsx");
				
				$http.post(api_url + '/user_statistics/save/trw',{}, {responseType: 'arraybuffer'}).then(
					function(response){
				
						var blob = new Blob([response.data], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"});
						saveAs(blob, 'Statystyki użytkownika Trw' + ".xlsx");
					}
				);
			}
		);	
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/user_statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.user_statistics = response.data.data.user_statistics.data;
					
					current_page = response.data.data.user_statistics;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/user_statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.user_statistics = response.data.data.user_statistics.data;
					
					current_page = response.data.data.user_statistics;					
				}
			}
		);
	}
	
});


sandhar.controller('AdminCurrentStatisticsController', function($scope, $http, promiseCurrentStatistics){
	$scope.current_statistics = promiseCurrentStatistics.data.data.current_statistics.data;
	
	current_page = promiseCurrentStatistics.data.data.current_statistics;
	
	$scope.search_field = 'product_id';
	
	$scope.CloseShowCurrentStatisticDialog = function(){
		jQuery('#show_current_statistic').modal('hide');
	}
	
	$scope.SearchCurrentStatistics = function(){
		jQuery('#search_current_statistic').modal('show');
	}
	
	$scope.searchCurrentStatisticEngine = function(event){
		
		if($scope.search == undefined){
			return;
		}
		
		$http.get(api_url + '/current_statistics').then(
			function success(response){
				$scope.current_statistics = response.data.data.current_statistics;
					
					if($scope.search_field == 'product_id'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (product.product_id.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'product_name'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (product.product_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'company_name'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (product.company_name.startsWith($scope.search))});																	
					}
					
					
					if($scope.search_field == 'min_production_level'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (String(product.min_production_level).startsWith($scope.search))});																	
					}										
					
					if($scope.search_field == 'number_of_good_products'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (String(product.number_of_good_products).startsWith($scope.search))});																	
					}	

					if($scope.search_field == 'number_of_bad_products'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (String(product.number_of_bad_products).startsWith($scope.search))});																	
					}	

					if($scope.search_field == 'number_of_sawn_products'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (String(product.number_of_sawn_products).startsWith($scope.search))});																	
					}

					if($scope.search_field == 'sum_of_products'){
						$scope.current_statistics = $scope.current_statistics.filter(function(product){ return (String(product.sum_of_products).startsWith($scope.search))});																	
					}
					
					if($scope.search == ''){
						$http.get(api_url + '/current_statistics?page=' + current_statistics_page).then(
							function(response){
								$scope.current_statistics = response.data.data.current_statistics.data;
							}
						);
					}
			});
	}
	
	$scope.ShowCurrentStatisticDialog = function(product_id){
		$http.get(api_url + '/current_statistics/' + product_id).then(
			function(response){
				if(response.data.success == true){
					$scope.current_statistic = response.data.data.current_statistic;
					
					jQuery('#show_current_statistic').modal('show');
				}
			}
		);
	}
	
	$scope.RefreshCurrentStatistics = function(){
		$http.get(api_url + '/current_statistics?page=' + current_statistics_page ).then(
			function(response){
				if(response.data.success == true){
					$scope.current_statistics = response.data.data.current_statistics.data;					
				}
			}
		);
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/current_statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.current_statistics = response.data.data.current_statistics.data;
					
					current_page = response.data.data.current_statistics;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/current_statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.current_statistics = response.data.data.current_statistics.data;
					
					current_page = response.data.data.current_statistics;					
				}
			}
		);
	}
});

sandhar.controller('AdminCurrentUserStatisticsController', function($scope, $http, promiseCurrentUserStatistics){
	$scope.current_user_statistics = promiseCurrentUserStatistics.data.data.current_user_statistics.data;
	
	current_page = promiseCurrentUserStatistics.data.data.current_user_statistics;
	
	$scope.search_field = 'product_id';
	
	$scope.CloseShowCurrentUserStatisticDialog = function(){
		jQuery('#show_current_user_statistic').modal('hide');
	}
	
	$scope.SearchCurrentUserStatistics = function(){
		jQuery('#search_current_user_statistic').modal('show');
	}
	
	$scope.searchCurrentUserStatisticEngine = function(event){
				
		if($scope.search == undefined){
			return;
		}
			
		$http.get(api_url + '/current_user_statistics').then(
			function success(response){
				$scope.current_user_statistics = response.data.data.current_user_statistics;
					
					if($scope.search_field == 'product_id'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (product.product_id.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'product_name'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (product.product_name.startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'company_name'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (product.company_name.startsWith($scope.search))});																	
					}
					
					
					if($scope.search_field == 'min_production_level'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (String(product.min_production_level).startsWith($scope.search))});																	
					}										
					
					if($scope.search_field == 'number_of_good_products'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (String(product.number_of_good_products).startsWith($scope.search))});																	
					}	

					if($scope.search_field == 'number_of_bad_products'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (String(product.number_of_bad_products).startsWith($scope.search))});																	
					}	

					if($scope.search_field == 'number_of_sawn_products'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (String(product.number_of_sawn_products).startsWith($scope.search))});																	
					}

					if($scope.search_field == 'sum_of_products'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (String(product.sum_of_products).startsWith($scope.search))});																	
					}
					
					if($scope.search_field == 'username'){
						$scope.current_user_statistics = $scope.current_user_statistics.filter(function(product){ return (String(product.username).startsWith($scope.search))});																	
					}
					
					if($scope.search == ''){
						$http.get(api_url + '/current_user_statistics?page=' + current_users_statistics_page).then(
							function(response){
								$scope.current_user_statistics = response.data.data.current_user_statistics.data;
							}
						);
					}
				}
			);
	}
	
	$scope.ShowCurrentUserStatisticDialog = function(product_id, username){
		$http.get(api_url + '/current_user_statistics/' + product_id + '/' + username).then(
			function(response){
				if(response.data.success == true){
					$scope.current_user_statistic = response.data.data.current_user_statistic;
					
					jQuery('#show_current_user_statistic').modal('show');
				}
			}
		);
	}
	
	$scope.RefreshCurrentUserStatistics = function(){
		$http.get(api_url + '/current_user_statistics?page=' + current_users_statistics_page).then(
			function(response){
				if(response.data.success == true){
					$scope.current_user_statistics = response.data.data.current_user_statistics.data;					
				}
			}
		);
	}
	
	$scope.PreviousPage = function(){
		
		if(current_page.prev_page_url == null){
			return;
		}
		
		page = current_page.current_page - 1;
		
		
		$http.get(api_url + '/current_user_statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.current_user_statistics = response.data.data.current_user_statistics.data;
					
					current_page = response.data.data.current_user_statistics;
				}
			}
		);
	}
	
	$scope.NextPage = function(){
		
		if(current_page.next_page_url == null){
			return;
		}
		
		page = current_page.current_page + 1;
		
		$http.get(api_url + '/current_user_statistics?page=' + page).then(
			function(response){
				if(response.data.success == true){
					$scope.current_user_statistics = response.data.data.current_user_statistics.data;
					
					current_page = response.data.data.current_user_statistics;					
				}
			}
		);
	}
});

sandhar.controller('AccountUserWorkspaceController', function($scope, $http){
	$scope.login_username = localStorage.username;
	
	$scope.searchProduct = function(){
		
		if($scope.product_id != '' && localStorage.username != undefined){
			$http.get(api_url + '/current_user_statistics/' + $scope.product_id + '/' + localStorage.username).then(
				function(response){
					if(response.data.success == true){
						$scope.product_result = response.data.data.current_user_statistic;
					}
					
					else{
						$scope.product_result = undefined;
					}
				}
			);
		}
		else{
			$scope.product_result = undefined;
		}
	}
	
	$scope.updateUserProduct = function(keyCode){
		
		$scope.login_username = localStorage.username;
		
		$scope.data_tmp = {};
				
		
		if($scope.data == undefined){
			return true;
		}
		
		key = Object.keys($scope.data)[0];
		
		if(key == undefined){
			return true;
		}
		
		$scope.data_tmp[key] = $scope.data[key] + $scope.product_result[key];
		
		
		if(keyCode != undefined && keyCode == 13 && $scope.data_tmp != undefined){
			$http.put(api_url + '/current_user_statistics/' + $scope.product_id + '/' + $scope.login_username, $scope.data_tmp, ).then(
				function success(response){
					$scope.product_result = response.data.data.current_user_statistic;
					$scope.data = {}
				}
			);
		}
		
		if(keyCode == undefined && $scope.data_tmp != undefined){
			$http.put(api_url + '/current_user_statistics/' + $scope.product_id + '/' + $scope.login_username, $scope.data_tmp, ).then(
				function success(response){
					$scope.product_result = response.data.data.current_user_statistic;
					$scope.data = {}
				}
			);
		}
	}
	
	$scope.updateUserProductDefect = function(keyCode){
		
		$scope.login_username = localStorage.username;
		$scope.data_tmp = {};
		
		if($scope.data == undefined){
			return true;
		}
		
		key = Object.keys($scope.data)[0];
		
		if(key == undefined){
			return true;
		}
		
		$scope.data_tmp[key] = $scope.data[key] + $scope.product_result[key];
		
		if(key == 'number_of_good_products'){
			$scope.data_tmp['success'] = $scope.data[key];
		}
		
		else{
			$scope.data_tmp['error'] = $scope.data[key];
		}
		
		if(keyCode != undefined && keyCode == 13 && $scope.data_tmp != undefined){
			$http.put(api_url + '/current_user_statistics/' + $scope.product_id + '/' + $scope.login_username, $scope.data_tmp, ).then(
				function success(response){
					$scope.product_result = response.data.data.current_user_statistic;
					$scope.data = {}
				}
			);
		}
		
		if(keyCode == undefined && $scope.data_tmp != undefined){
			$http.put(api_url + '/current_user_statistics/' + $scope.product_id + '/' + $scope.login_username, $scope.data_tmp, ).then(
				function success(response){
					$scope.product_result = response.data.data.current_user_statistic;
					$scope.data = {}
				}
			);
		}
	}
	
	$scope.updateUserProductAttentions = function(keyCode){
		$scope.login_username = localStorage.username;
		
		$scope.data_tmp = {};
		
		$scope.data_tmp['attentions']  = $scope.attentions;
		
		 	
		$http.put(api_url + '/current_user_statistics/' + $scope.product_id + '/' + $scope.login_username, $scope.data_tmp ).then(
			function success(response){
				$scope.product_result = response.data.data.current_user_statistic;
				$scope.data = {}
				$scope.data_tmp = {}
			}
		);
	}
	
});