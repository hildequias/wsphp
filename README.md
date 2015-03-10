# wsphp
Example Web Service PHP

Instructions
Execute the script database.sql in MySQL database for create database.

Example to call

GET
http://localhost/wsphp/server/routes/routes -> get a route's list
http://localhost/wsphp/server/routes/route/5 -> get a route with ID 5

POST
http://localhost/wsphp/server/routes/save -> save a route, it is need to send a json how example: {"origem":"A","destino":"B","nome":"Exemplo X","distancia":"50.0000"}
http://localhost/wsphp/server/routes/routemap -> return a route's list, it is need to send a json how example: {"origem":"A","destino":"B","autonomia":"12","valor_litro":"3.30"}

autonomia is value car wheel by kilometer gas
valor_litro is a price by a liter of gasoline.
origem is a point A and destino is a point B.
nome is a route nickname.
