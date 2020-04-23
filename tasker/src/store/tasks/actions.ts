export function createTask({commit}, payload) {
  return new Promise ((res, rej) => {
    this._vm.$axios.post('/tasks',
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
export function updateTask({commit}, payload) {
  return new Promise ((res, rej) => {
    this._vm.$axios.put('/tasks/' + payload.id,
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

