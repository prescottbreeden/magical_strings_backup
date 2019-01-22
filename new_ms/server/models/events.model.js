const mongooose = require('mongoose');
mongooose.connect('mongodb://localhost:27017/magical_strings', { useNewUrlParser: true })

const EventSchema = new mongooose.Schema({
  name: {
    type: String,
    required: [true, "'Name' cannot be empty."]
  },
   
}, { timestamps: true });

module.exports = mongoose.model('Events', EventsSchema);