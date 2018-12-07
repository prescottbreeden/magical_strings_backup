const mongooose = require('mongoose');
mongooose.connect('mongodb://localhost:27017/magical_strings', { useNewUrlParser: true })

const AdminSchema = new mongooose.Schema({
  name: {
    type: String,
    required: [true, "'Name' cannot be empty."]
  },
  email: {
    type: String,
    required: [true, "'Email' cannot be blank."]
  },
  password: {
    type: String,
    required: [true, "'Password' cannot be blank"]
  }
   
}, { timestamps: true });

module.exports = mongoose.model('Admin', AdminSchema);