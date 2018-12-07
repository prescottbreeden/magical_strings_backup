const mongooose = require('mongoose');
mongooose.connect('mongodb://localhost:27017/magical_strings', { useNewUrlParser: true })

const BlogSchema = new mongooose.Schema({
  title: {
    type: String,
    required: [true, "'Title' cannot be empty."]
  },
  post: {
    type: String,
    required: [true, "'Post' cannot be blank."]
  }
   
}, { timestamps: true });

module.exports = mongoose.model('Blog', BlogSchema);