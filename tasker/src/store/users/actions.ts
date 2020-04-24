export function getUserProfile({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.get('/users/' + payload,
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
