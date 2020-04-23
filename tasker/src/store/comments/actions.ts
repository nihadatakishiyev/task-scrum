export function createComment({commit}, payload) {
  console.log(payload)
  return new Promise((res, rej) => {
     this._vm.$axios.post('/comments',
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
export function getComments({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('/tasks/' + payload,
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
export function deleteComments({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.delete('/comments/'+payload,
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
