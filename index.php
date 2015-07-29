<?php

echo "Tentativo di connessione al DB MongoDB.","<br/>";

$documento = array(
		
		'nome' => 'Marco',
		'cognome' => 'Rossi',
		'telefono' => [
			array(
				'tipo' => 'cellulare',
				'numero' => '3200000000'
			),
			array(
				'tipo' => 'cellulare',
				'numero' => '34911111111'
			)],
		'Email' => array(
			"prima@email.com",
			"seconda@email.com",
			"altra@gmail.com",
			"ultima@hotmail.it"
		),
		'indirizzo' => 'Viale Italia 100',
		'citta' => 'Roma',
		'CAP' => '00100',
		'provincia' => 'Roma',
		'stato' => 'Italia'
	);
/*
var_dump($documento);
die;
*/

try{
	// Creo una istanza della classe MongoClient.
	$m = new MongoClient("127.0.0.1:27017");
	echo "Connessione effettuata","<br/>";

	// Seleziono il database "test" e la collezione "prova" e la assegno all'oggetto $c.
	// In alternativa posso usare la selectDB: $db = $m->selectDB("test") e la collezione
	// con selectCollection: $c = $db->selectCollection("prova") o chiamarle in un unica
	// riga: $c = $m->selectDB("test")->selectCollection("prova"). Posso usare i comandi
	// listDBs() e listCollections() per avere la lista dei DB e delle Collezioni.
	$c = $m->test->prova;

	// Imposto i parametri di Concern. Il primo parametro rappresenta il valore del parametro "w".
	// Di default w=0, ovvero la scrittura è asincrona. Non attendo risposta dal server. Con w=1
	// attendo risposta. Con w>=2 attendo risposta per ogni replica del server di DB.
	$c->setWriteConcern(1,1000);
	// Alternativa per la definizione di un array di opzioni. Gli altri parametri sono j, fsync
	// e timeout
	$opzioni = array('w'=>1,'wtimeout'=>1000);

	// Invio una INSERT al DB. In alternativa posso usare la SAVE. Quest'ultima se trova già la chiave
	// anzichè lanciare una eccezione, farà un aggiornamento del documento.
	$c->insert($documento); //, array('w'=>1));
	echo $documento['_id'],"<br/>";

	// Il campo _id rappresenta un oggetto della classe MongoId se lasciato impostare da MongoDB e
	// pertanto posso accedere ad una serie di metodi come ad esempio il getTimestamp().
	$id=$documento['_id'];
	echo $id->getTimestamp(),"<br/>";

	//$documento = $c->findOne(array('_id'=>new MongoId('55b783a9c86996310c0041b0')));
	$documento = $c->findOne(array(),array('provincia'));
	var_dump ($documento);
	//var_dump($documento);

	// Chiudo la connessione al DB. Non è necessario se non in particolari casi.
	$m->close();
}catch(MongoException $e){
	echo $e->getMessage(),"<br/>";
}
finally{
	echo "Fine","<br/>";
}



?>