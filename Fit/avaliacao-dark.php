<?php


$idacademia = 4;
$idaluno=0;
$carregado = false;
$ativarBotoes = false;

?>
<html lang="pt-br" >

  <title>ZM Fit - Personal</title>
  
  <meta charset="UTF-8">
  <meta name="robots" content="noindex">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="msapplication-square310x310logo" content="icon_largetile.png">
  
  <link rel="icon" href="https://zmfit.com.br/wp-content/uploads/2020/02/logo1-1.png" sizes="32x32" />
  <link rel="icon" href="https://zmfit.com.br/wp-content/uploads/2020/02/logo1-1.png" sizes="192x192" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap">
  <link rel="stylesheet" href="css/angular-material.css">
  <link rel="stylesheet" href="css/docs.css">
  <link rel="apple-touch-icon" href="ios-icon.png">
  <link rel="icon" sizes="192x192" href="icon.png">

  <script src="js/iframeConsoleRunner-dc0d50e60903d6825042d06159a8d5ac69a6c0e9bcef91e3380b17617061ce0f.js"></script>
  <script src="js/iframeRefreshCSS-d00a5a605474f5a5a14d7b43b6ba5eb7b3449f04226e06eb1b022c613eabc427.js"></script>
  <script src="js/iframeRuntimeErrors-29f059e28a3c6d3878960591ef98b1e303c1fe1935197dae7797c017a3ca1e82.js"></script>
  <script src="js/screenfull.min.js"></script>

  <style class="INLINE_PEN_STYLESHEET_ID"></style>
  <style type="text/css">
    
    html {
       
      margin: 0;
      padding: 0;
      font-family: 'Baloo Chettan 2', cursive;

    }

    md-progress-circular {

      height: 10em;
      margin: 0;
      position: absolute;
      top: 50%;
      left: 50%;
      margin-right: -50%;
      transform: translate(-50%, -50%) 
    }

  </style>  

  <div ng-controller="AppCtrl" layout="row" ng-cloak="" class="sidenavdemoBasicUsage" ng-app="MyApp" md-theme="{{ dynamicTheme }}" md-theme-watch>
    
    <div layout="column" flex="">
    
      <div>
        
        <md-toolbar md-whiteframe="8"layout="row">
          <h1 class="md-toolbar-tools">Header</h1>
          <md-button ng-click="dynamicTheme = 'default'">Default</md-button>
          <md-button ng-click="dynamicTheme = 'altTheme'">altTheme</md-button>
        </md-toolbar>
      </div>
      <section layout="row" flex="">

        <md-sidenav class="md-sidenav-left" md-component-id="left" md-is-locked-open="$mdMedia('gt-md')" md-disable-backdrop="" md-whiteframe="4">

          <md-toolbar class="md-accent">
            <h1 class="md-toolbar-tools">Sidenav Left</h1>
          </md-toolbar>
          
          <md-content layout-padding="" ng-controller="LeftCtrl">
            <md-button ng-click="close()" class="md-primary" hide-gt-md="">
              Close Sidenav Left
            </md-button>
            <p hide-md="" show-gt-md="">
              This sidenav is locked open on your device. To go back to the default behavior,
              narrow your display.
            </p>
          </md-content>

        </md-sidenav>

        <md-content flex="" layout-padding="">

          <div layout="column" layout-fill="" layout-align="top center">
            <md-button ng-click="toggleRight()" ng-hide="isOpenRight()" class="md-primary md-raised">
              Toggle right
            </md-button>
            <md-button ng-click="toggleLeft()" class="md-primary" hide-gt-md="">
              Toggle left
            </md-button>
            <h4>Standard date-picker</h4>
            <md-datepicker ng-model="myDate" md-placeholder="Enter date"></md-datepicker>
            <md-checkbox ng-model="ctrl.noCache">Disable caching of queries?</md-checkbox>
            <md-checkbox ng-model="ctrl.isDisabled">Disable the input?</md-checkbox>
            <section layout="row" layout-sm="column" layout-align="center center" layout-wrap>
              <md-button class="md-raised">Button</md-button>
              <md-button class="md-raised md-primary">Primary</md-button>
              <md-button ng-disabled="true" class="md-raised md-primary">Disabled</md-button>
              <md-button class="md-raised md-warn">Warn</md-button>
              <div class="label">Raised</div>
            </section>
            
            <p>
            The left sidenav will 'lock open' on a medium (>=960px wide) device.
            </p>
            <p>
            The right sidenav will focus on a specific child element.
            </p>

          </div>

          <div flex=""></div>

        </md-content>

        <md-sidenav class="md-sidenav-right md-whiteframe-4dp" md-component-id="right">

          <md-toolbar class="md-theme-light">
            <h1 class="md-toolbar-tools">Sidenav Right</h1>
          </md-toolbar>
          <md-content ng-controller="RightCtrl" layout-padding="">
            <form>
              <md-input-container>
                <label for="testInput">Test input</label>
                <input type="text" id="testInput" ng-model="data" md-autofocus="">
              </md-input-container>
            </form>
            <md-button ng-click="close()" class="md-primary">
              Close Sidenav Right
            </md-button>
          </md-content>

        </md-sidenav>

      </section>
    </div>
  </div>


  <script src="js/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
  <script src="js/angular/angular.js"></script>
  <script src="js/angular/angular-animate.min.js"></script>
  <script src="js/angular/angular-route.min.js"></script>
  <script src="js/angular/angular-aria.min.js"></script>
  <script src="js/angular/angular-messages.min.js"></script>
  <script src="js/angular/moment.js"></script>
  <script src="js/angular/svg-assets-cache.js"></script>
  <script src="js/angular/angular-material.js"></script>
  <script type="text/javascript">
    angular

      .module('MyApp',['ngMaterial', 'ngMessages', 'material.svgAssetsCache'])
      .config(function($mdThemingProvider) {
      $mdThemingProvider.theme('altTheme')
         .primaryPalette('grey',{
        'default': '900'})
         .accentPalette('grey',{
        'default': '700'})
         .backgroundPalette('grey',{
          'default': '700'})
      .dark()

 //.backgroundPalette('brown',{'default': '500'})

      ; 
//  <!-- orson 說太紅了 要灰的  --> 
//   $mdThemingProvider.theme('altTheme')
//        .primaryPalette('red',{
//       'default': '400'})
//        .accentPalette('deep-purple',{
//       'default': 'A700'})
//        .backgroundPalette('brown',{
//       'default': '50'})
// ; 
      $mdThemingProvider.theme('default')

        .primaryPalette('blue',{
        'default': '900'})
        .accentPalette('white',{
        'default': '700'})
        .backgroundPalette('red',{
          'default': '700'})
        .dark()
//      .dark();
      $mdThemingProvider.setDefaultTheme('altTheme');
      $mdThemingProvider.alwaysWatchTheme(true);
    })


    .controller('AppCtrl', function ($scope, $timeout, $mdSidenav, $log) {
      $scope.toggleLeft = buildDelayedToggler('left');
      $scope.toggleRight = buildToggler('right');
      $scope.isOpenRight = function(){
        return $mdSidenav('right').isOpen();
      };

  /**
   * Supplies a function that will continue to operate until the
   * time is up.
   */
      function debounce(func, wait, context) {
        var timer;

        return function debounced() {
          var context = $scope,
              args = Array.prototype.slice.call(arguments);
          $timeout.cancel(timer);
          timer = $timeout(function() {
            timer = undefined;
            func.apply(context, args);
          }, wait || 10);
        };
      }

  /**
   * Build handler to open/close a SideNav; when animation finishes
   * report completion in console
   */
  function buildDelayedToggler(navID) {
    return debounce(function() {
      $mdSidenav(navID)
        .toggle()
        .then(function () {
          $log.debug("toggle " + navID + " is done");
        });
    }, 200);
  }

  function buildToggler(navID) {
    return function() {
      $mdSidenav(navID)
        .toggle()
        .then(function () {
          $log.debug("toggle " + navID + " is done");
        });
    }
  }
})
.controller('LeftCtrl', function ($scope, $timeout, $mdSidenav, $log) {
  $scope.close = function () {
    $mdSidenav('left').close()
      .then(function () {
        $log.debug("close LEFT is done");
      });

  };
})
.controller('RightCtrl', function ($scope, $timeout, $mdSidenav, $log) {
  $scope.close = function () {
    $mdSidenav('right').close()
      .then(function () {
        $log.debug("close RIGHT is done");
      });
  };
});


  </script>

</html>
