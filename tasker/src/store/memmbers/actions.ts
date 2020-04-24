export function searchMemmber({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('/users?q=' + payload,
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(function (error) {
        rej(error.response)
      })
  })
}
export function updateUps({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.put('/ups/' + payload.id,
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(function (error) {
        rej(error.response)
      })
  })
}
export function getMemmbers({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('/ups' + payload,
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(function (error) {
        rej(error.response)
      })
  })
}
export function addMemmber({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.post('/ups',
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(function (error) {
        rej(error.response)
      })
  })
}
