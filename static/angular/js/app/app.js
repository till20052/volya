'use strict';

var app = angular.module('VolyaApp', ['ngAnimate', 'ngMaterial', 'ngMessages'])
	.config(function ($mdThemingProvider) {
		$mdThemingProvider.definePalette('volyaThema', {
			'50': '007EC9',
			'100': '007EC9',
			'200': '007EC9',
			'300': '007EC9',
			'400': '007EC9',
			'500': '007EC9',
			'600': '007EC9',
			'700': '007EC9',
			'800': '007EC9',
			'900': '007EC9',
			'A100': '007EC9',
			'A200': '007EC9',
			'A400': '007EC9',
			'A700': '007EC9',
			'contrastDefaultColor': 'light',    // whether, by default, text (contrast)
		                                        // on this palette should be dark or light
			'contrastDarkColors': ['50', '100', //hues which contrast should be 'dark' by default
				'200', '300', '400', 'A100'],
			'contrastLightColors': undefined    // could also specify this if default was 'dark'
		});

		$mdThemingProvider
			.theme('default')
			.primaryPalette('volyaThema')
			.accentPalette('volyaThema');
	})

	.config(['$httpProvider', function($httpProvider){
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

		$httpProvider.defaults.transformRequest = [function(data) {
			var param = function(obj) {
				var query = '';
				var name, value, fullSubName, subValue, innerObj, i, subName;

				for(name in obj) {
					value = obj[name];

					if(value instanceof Array) {
						for(i=0; i<value.length; ++i) {
							subValue = value[i];
							fullSubName = name + '[' + i + ']';
							innerObj = {};
							innerObj[fullSubName] = subValue;
							query += param(innerObj) + '&';
						}
					} else if(value instanceof Object) {
						for(subName in value) {
							subValue = value[subName];
							fullSubName = name + '[' + subName + ']';
							innerObj = {};
							innerObj[fullSubName] = subValue;
							query += param(innerObj) + '&';
						}
					} else if(value !== undefined && value !== null) {
						query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
					}
				}

				return query.length ? query.substr(0, query.length - 1) : query;
			};

			return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
		}];
	}]);
