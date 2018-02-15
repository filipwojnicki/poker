//zdefiniowanie aplikacji poker wraz z modulem ngroute

var app = angular.module('poker', ["ngRoute"]);

// Obsługa przekierowań(routes) jak i lokalizacji, skrócone linki 

app.config(['$routeProvider','$locationProvider',
  function($routeProvider, $locationProvider) {
    $routeProvider
      // strona główna
      .when("/", {
        // pod adresem / (domyślnym) view(widok) strony ustalany jest na strone main.html
        templateUrl : "./views/main.html",
      })
      // my games
      .when("/mygames", {
        templateUrl : "./views/mygames.html",
      })
      // tables
      .when("/tables", {
        templateUrl : "./views/listtable.html",
      })
      // game
      .when("/game/:id/:token", {
        templateUrl : "./views/game.html",
      })
      // inny przypadek
      .otherwise({
        redirectTo : "/"
      });

    
    $locationProvider.hashPrefix('');

    /*
    $locationProvider.html5Mode({
           enabled: true,
           requireBase: false
    });
    */
}]);

// ------------------------ LIST TABLE CONTROLLER --------------------------------------------

// /tables Controller odpowiadający za wyświetlenie listy dostępnych stołów do gry jak i dodanie nowego

app.controller('listTablesController', function($scope, $http) {

  // funckja odpowiadająca za odświeżenie dostępnych stołów dla użytkownika
  refreshTables();
 
  // funkcja dla przycisku odśwież
  $scope.getTables = function() {
    refreshTables();
  };

  // funkcja dla przycisku stwórz stół 
  $scope.createTable = function() {
    var formData = { tableName: $scope.table_name};
    var postData = 'myData='+JSON.stringify(formData);
    // przesłanie danych z formularza(modal) w formacie JSON do pliku createTable
    $http({
            method : 'POST',
            url : 'php/createTable.php',
            data: postData,
            // określenie typu przesyłania dla wysłania formularza bez action i przekierowania
            headers : {'Content-Type': 'application/x-www-form-urlencoded'}  

    }).then(

    // sukces w przesyłaniu

    function(res){

      // debug
      //console.log(res);

      // HTTP kod 201 - oznacza Created (utworzone) zwraca go serwer(plik) w przypadku pomyślnego wykonania kodu

      if(res.status == "201"){

        //debug
        //console.log("ok");

        //obsługa komuniaktu tekstowego i wyświetlenie komunikatu typu toaster (fixed alert w prawym górnym rogu) 
        $scope.message = "Stół został dodany.";
        $.toaster({ priority : 'success', title : 'INFO', message : 'Stół został utworzony.'});
        refreshTables();
      }else{
        // w przypadku innego kodu zwrotnego niż 201 wyświetl komunikat
        $scope.message = "Błąd przy dodawaniu stołu.";
      }
    },

    // błąd podczas przysłania

    function(err) {
      $scope.message = "Błąd przy dodawaniu stołu.";
      $.toaster({ priority : 'error', title : 'INFO', message : 'Błąd przy dodawaniu stołu.'});

      //debug
      //console.log('error...', err);
      //deferred.resolve(err);
    });
  };

  // odświeżenie zbioru danych dla tabeli wyświetlającej dostępne stoły
  function refreshTables(){
    // pobranie danych w formacie JSON z pliku getTables
    $http.get("php/getTables.php").then(function(response) {
      // przypisanie danych w formacie JSON do obiektu tables 
      $scope.tables = response.data;

      //debug
      //console.log($scope.tables[2].id);
      if(typeof response.data === "undefined" || response.data == "" || response.data === "null"){
        $scope.tableerrormsg = "Brak stołu w którym mógłbyś zagrać.";
      }else{
        $scope.tableerrormsg = "";
      }
    });
  }

});

// ------------------------- MY GAMES CONTROLLER -----------------------------------------------

// /mygames Controller odpowiadający za wyświetlenie aktualnie granych gier przez użytkownika

app.controller('myGamesController', function($scope, $http) {

  // funkcja pozyskująca aktualne rozgrywki
  refreshGames();
 
  // funkcja do której odwołuje się przycisk odśwież
  $scope.getGames = function() {
    refreshGames();
  };

  // funckja pozyskująca aktualne rozgrywki prowadzone przez gracza
  function refreshGames(){
    // pozyskuje je przez pobranie danych w formacie JSON z pliku getCurrentGames (API)
    $http.get("php/getCurrentGames.php").then(function(response) {
      
      // ustalenie obiektu games z danymi typu JSON
      $scope.games = response.data;

      // jeżeli dane są niedostępne ustal komunikat
      if(typeof response.data === "undefined" || response.data == "" || response.data === "null"){
        $scope.gameerrormsg = "Brak aktualnych rozgrywek.";
      // poprawienie komunikatu w przypadku nie odświeżenia strony 
      }else{
        $scope.gameerrormsg = "";
      }
    });
  }

});

// ----------------------------- SHOW5RANDOM CONTROLLER --------------------------------------------------------

// /main Pokazanie 5 losowych kart na stronie głównej

app.controller('show5random', function($scope, $http) {
  // pozyskanie ich odbywa się przez pobranie danych w formacie JSON z pliku get5randcards (API)
  $http.get("php/get5randcards.php").then(function(response) {
    $scope.randcards = response.data;
  });
});

// ----------------------------- NAV CONTROLLER ---------------------------------------------------------------

// Menu Controller odpowiadający za określenie aktualnie przeglądanej strony

app.controller('navController', function($scope, $location) {
    $scope.isActive = function(route) {
      return route === $location.path();
    }
});

app.controller('gameController', function($scope, $routeParams,$http) {
  var id = $routeParams.id;
  var token = $routeParams.token;
  $scope.errorShow = false;

  getGameData(id, token);

  function getGameData(id, token){
    var formData = { id: id, token: token};
    var postData = 'myData='+JSON.stringify(formData);
    
    //debug
    //console.log(id, token, postData);

    $http({
        method : 'POST',
        url : 'php/gameController.php',
        data: postData,
        // określenie typu przesyłania dla wysłania formularza bez action i przekierowania
        headers : {'Content-Type': 'application/x-www-form-urlencoded'}  
    }).then(

    // sukces w przesyłaniu

    function(res){

      // debug
      //console.log(res);

      // HTTP kod 201 - oznacza Created (utworzone) zwraca go serwer(plik) w przypadku pomyślnego wykonania kodu

      if(res.status == "201"){

        $scope.gameData = res.data;
        //console.log($scope.gameData);

        //debug
        //console.log("ok");

        if($scope.gameData.msg){
          $.toaster({ priority : 'info', title : 'INFO', message : $scope.gameData.msg});
        }

        //obsługa komuniaktu tekstowego i wyświetlenie komunikatu typu toaster (fixed alert w prawym górnym rogu) 
       $.toaster({ priority : 'info', title : 'INFO', message : 'Dołączono'});
      }else if(res.status == "404"){
        $scope.message = "Błąd przy dołączaniu do gry.";
        $scope.errorShow = true;
        $.toaster({ priority : 'danger', message : 'Błąd przy dołączaniu do gry.'});
      }else{
        // w przypadku innego kodu zwrotnego niż 201 wyświetl komunikat
        $scope.message = "Błąd przy dołączaniu do gry. ";
        $scope.errorShow = true;
        $.toaster({ priority : 'danger', message : 'Błąd przy dołączaniu do gry.'});
      }
    },

    // błąd podczas przysłania

    function(err) {
      $scope.message = "Błąd przy dołączaniu do gry. ";
      $scope.errorShow = true;
      $.toaster({ priority : 'danger', message : 'Błąd przy dołączaniu do gry.'});
    });
  };

  // Obsługa gracza

   $scope.fold = function() {
    var formData = { id: id, token: token, fold: "fold"};
    var postData = 'myData='+JSON.stringify(formData);
    
    //debug
    //console.log(id, token, postData);

    $http({
        method : 'POST',
        url : 'php/gameController.php',
        data: postData,
        headers : {'Content-Type': 'application/x-www-form-urlencoded'}  
    }).then(
    function(res){
      console.log(res);
      $('.game-butt').addClass('disabled'); // Disables visually
      $('.game-butt').prop('disabled', true);

      // debug
      //console.log(res);

      // HTTP kod 201 - oznacza Created (utworzone) zwraca go serwer(plik) w przypadku pomyślnego wykonania kodu

      if(res.status == "201"){

        $scope.gameStatus = res.data;
        $.toaster({ priority : 'success', message : 'Gra zakończona.'});
        $scope.message = "Gra zakończona zwycięża John";
        $scope.errorShow = true;

        //console.log($scope.gameStatus);

        //debug
        //console.log("ok");

        
      }else if(res.status == "404"){
        $scope.message = "Błąd gry.";
        $scope.errorShow = true;
        $.toaster({ priority : 'danger', message : 'Błąd gry.'});
      }else{
        // w przypadku innego kodu zwrotnego niż 201 wyświetl komunikat
        $scope.message = "Błąd gry. ";
        $scope.errorShow = true;
        $.toaster({ priority : 'danger', message : 'Błąd gry.'});
      }
    },    // błąd podczas przysłania

    function(err) {
      $scope.message = "Błąd gry. ";
      $scope.errorShow = true;
      $.toaster({ priority : 'danger', message : 'Błąd gry.'});
      //console.log(err);
    });
  };

  $scope.call = function() {
    var formData = { id: id, token: token, call: "call"};
    var postData = 'myData='+JSON.stringify(formData);
      
    //debug
    //console.log(id, token, postData);

    $http({
        method : 'POST',
        url : 'php/gameController.php',
        data: postData,
        headers : {'Content-Type': 'application/x-www-form-urlencoded'}  
    }).then(
      function(res){
       // console.log(res);
        getGameData(id, token);

       // $.toaster({ priority : 'success', message : 'Dodatkowa karta.'});
       // $('.game-butt').addClass('disabled');
       // $('.game-butt').prop('disabled', true);

        // debug
        //console.log(res);

        // HTTP kod 201 - oznacza Created (utworzone) zwraca go serwer(plik) w przypadku pomyślnego wykonania kodu

        if(res.status == "201"){
       //   console.log(res);
          $scope.gameStatus = res.data;
          $.toaster({ priority : 'success', message : 'Dodatkowa karta. - Call'});

          //console.log($scope.gameStatus);

          //debug
          //console.log("ok");

          
        }else if(res.status == "404"){
          $scope.message = "Błąd gry.";
          $scope.errorShow = true;
          $.toaster({ priority : 'danger', message : 'Błąd gry.'});
        }else{
          // w przypadku innego kodu zwrotnego niż 201 wyświetl komunikat
          $scope.message = "Błąd gry. ";
          $scope.errorShow = true;
          $.toaster({ priority : 'danger', message : 'Błąd gry.'});
        }
      },    // błąd podczas przysłania

      function(err) {
        $scope.message = "Błąd gry.";
        $scope.errorShow = true;
        $.toaster({ priority : 'danger', message : 'Błąd gry.'});
        //console.log(err);
      });
   };


});