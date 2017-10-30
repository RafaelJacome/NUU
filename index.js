var express = require('express');
var app = express();
var path    = require("path");

app.get('/',function(req,res){
  res.sendFile(path.join(__dirname+'/index.html'));
});

app.use('/dist', express.static('dist'));

var port = process.env.PORT || 3000;
app.listen(port);