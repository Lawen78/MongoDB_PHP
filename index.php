<?php

echo "Tentativo di connessione al DB MongoDB.","<br/>";

$documento = array(
		
		'nome' => 'Marco',
		'cognome' => 'Rossi',
		'telefono' => [
			array(
				'tipo' => 'cellulare',
				'numero' => '3204088736'
			),
			array(
				'tipo' => 'cellulare',
				'numero' => '3204088736'
			)],
		'indirizzo' => 'Viale Ungheria 92a',
		'citta' => 'Zagarolo',
		'CAP' => '00039',
		'provincia' => 'Roma',
		'stato' => 'Italia'
	);
/*
var_dump($documento);
die;
*/

try{
	$m = new MongoClient("127.0.0.1:27017");
	echo "Connessione effettuata","<br/>";

	$c = $m->test->prova;
	$c->setWriteConcern(1,1000);
	$c->insert($documento); //, array('w'=>1));
	echo $documento['_id'],"<br/>";
	$id=$documento['_id'];
	echo $id->getTimestamp(),"<br/>";

	//$documento = $c->findOne(array('_id'=>new MongoId('55b783a9c86996310c0041b0')));
	$documento = $c->findOne(array(),array('provincia'));
	var_dump ($documento);
	//var_dump($documento);
	$m->close();
}catch(MongoException $e){
	echo $e->getMessage(),"<br/>";
}
finally{
	echo "Fine","<br/>";
}



?>