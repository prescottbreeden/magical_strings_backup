const Events = require('./models/events.model');


module.exports = {

  getAll: (req, res) => {
    Events.find({})
      .then(results => res.json(results))
      .catch(err => res.json(err))
  },

  getOne: (req, res) => {
    const ID = req.params.id;
    Events.find({_id: ID})
      .then(results => res.json(results))
      .catch(err => res.json(err))
  },

  createNew: (req, res) => {
    const DATA = req.body;
    
    Events.create(DATA)
      .then(results => res.json(results))
      .catch(err => res.json(err));
  }
}
