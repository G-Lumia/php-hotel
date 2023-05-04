<!-- Prima stampate in pagina i dati, senza preoccuparvi dello stile.
Dopo aggiungete Bootstrap e mostrate le informazioni con una tabella.
1 - Aggiungere un form ad inizio pagina che tramite una richiesta GET permetta di filtrare gli hotel che hanno un parcheggio.
2 - Aggiungere un secondo campo al form che permetta di filtrare gli hotel per voto (es. inserisco 3 ed ottengo tutti gli hotel che hanno un voto di tre stelle o superiore)
NOTA: deve essere possibile utilizzare entrambi i filtri contemporaneamente (es. ottenere una lista con hotel che dispongono di parcheggio e che hanno un voto di tre stelle o superiore)
Se non viene specificato nessun filtro, visualizzare come in precedenza tutti gli hotel. -->


<?php
    // il vettore contenente gli hotel
    $hotels = [

        [
            'name' => 'Hotel Belvedere',
            'description' => 'Hotel Belvedere Descrizione',
            'parking' => true,
            'vote' => 4,
            'distance_to_center' => 10.4
        ],
        [
            'name' => 'Hotel Futuro',
            'description' => 'Hotel Futuro Descrizione',
            'parking' => true,
            'vote' => 2,
            'distance_to_center' => 2
        ],
        [
            'name' => 'Hotel Rivamare',
            'description' => 'Hotel Rivamare Descrizione',
            'parking' => false,
            'vote' => 1,
            'distance_to_center' => 1
        ],
        [
            'name' => 'Hotel Bellavista',
            'description' => 'Hotel Bellavista Descrizione',
            'parking' => false,
            'vote' => 5,
            'distance_to_center' => 5.5
        ],
        [
            'name' => 'Hotel Milano',
            'description' => 'Hotel Milano Descrizione',
            'parking' => true,
            'vote' => 2,
            'distance_to_center' => 50
        ],

    ];

    // il vettore che conterrà gli hotel filtrati
    $filteredHotels = [];
    
    //viene verificato che i vari GET siano stati settati
    if(isset($_GET['park']) && isset($_GET['vote'])){
        //vengono create due variabili per contenere il valore settato
        $park = $_GET['park'];
        $vote = $_GET['vote'];
        // se park e vote hanno un valore diverso da quello iniziale
        if($park != "none" && $vote!= "1"){
            foreach($hotels as $hotel){
                //viene verificato che le key parking e vote di hotel rispettino i parametri di ricerca
                if($hotel['parking'] == $park && $hotel['vote'] >= $vote){
                    //hotel viene inserito nell'array filteredHotels
                    $filteredHotels [] = $hotel;
                }
            }
        }
        // se soltanto park ha un valore diverso da quello iniziale
        elseif ($park != "none"){
            foreach($hotels as $hotel){
                //viene verificato che la key parking rispetti i parametri di ricerca
                if($hotel['parking'] == $park){
                    //hotel viene inserito nell'array filteredHotels
                    $filteredHotels [] = $hotel;
                }
            }
        }
        // se soltanto vote ha un valore diverso da quello iniziale
        elseif ($vote!= "none"){
            foreach($hotels as $hotel){
                //viene verificato che la key vote rispetti i parametri di ricerca
                if($hotel['vote'] >= $vote){
                    //hotel viene inserito nell'array filteredHotels
                    $filteredHotels [] = $hotel;
                }
            }
        }
        //altrimenti, se non vengono inseriti parametri di ricerca, filteredHotels copia i contenuti di hotels
        else{
            $filteredHotels = $hotels;
        }
    }
    // altrimenti, se i valori non sono stati settati, filteredHotels copia i contenuti di hotels
    else{
        $filteredHotels = $hotels;
    }
    ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  </head>

  <body class = "bg-secondary">
    <div class="container d-flex flex-column align-items-center py-5">
        <h1 class="text-light"> Hotels Chooser </h1>
        <!-- form di ricerca -->
        <form class="my-3 p-3 d-flex flex-column align-items-center gap-3 bg-light rounded" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET">
            <div>
                <label for="park">Parking avaiable: </label>
                <select name="park" id="park">
                    <option value="none">Not relevant</option>
                    <option value="1"> Yes </option>
                    <option value="0"> No </option>
                </select>
            </div>
            <div>
                <label for="vote"> Rating: </label>
                <select name="vote" id="vote">
                    <option value="1" > 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                </select>
            </div>
            <input type="submit" name="submit" value="Search">
        </form>

        <!-- creazione della tabella degli hotel -->
        <table class="table table-dark">
            <thead>
                <tr>
                    <!-- Key degli elementi in $hotels -->
                    <?php foreach(array_keys($hotels[0]) as $keyName) { ?>
                        <th scope="col"><?php echo strtoupper($keyName) ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <!-- vengono inseriti gli hotel filtrati nella tabella -->
                <?php foreach($filteredHotels as $hotel){ ?>
                        <tr>
                            <td> <?php echo $hotel['name'] ?>  </td>
                            <td> <?php echo $hotel['description'] ?>  </td>
                            <td> 
                                <?php
                                // il booleano ' parking' viene gestito per stampare un determianto valore
                                    if($hotel['parking'] == 1) {
                                        echo "Yes";
                                    }
                                    else{
                                        echo "No";
                                    }?>  
                            </td>
                            <td> <?php echo $hotel['vote'] ?>  </td>
                            <td> <?php echo $hotel['distance_to_center']." km" ?>  </td>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>