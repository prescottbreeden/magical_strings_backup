const express = require('express');
const mongoose = require('mongoose');
const bp = require('body-parser');
const path = require('path');

const app = express();

app.use(bp.json());
app.use(bp.urlencoded({ extended: true }));
app.use(express.static( path.join(__dirname, './public/dist/public') ));

const PORT = 8080;
app.listen(PORT, ()=> {
  console.log("Listening on port: " + PORT);
})


