var Chance = require('chance');
var chance = new Chance();

var randomstring = require("randomstring");

var express = require('express');
var app = express();

app.get('/', function(req, res) {
  res.send(randomStrings());
});

app.listen(3000, function () {
  console.log("Acceptin HTTP requests on port 3000.");
});

function randomStrings() {
  var numberOfStrings = chance.integer({
    min: 1,
    max: 10
  });

  var String = [];
  for (var i = 1; i < numberOfStrings; ++i) {
    String.push({
      cluster: "Cluster 2",
      string: randomstring.generate({
        length: i,
        charset: 'custom'
      }),
      length: i
    });
  }
  return String;
}
