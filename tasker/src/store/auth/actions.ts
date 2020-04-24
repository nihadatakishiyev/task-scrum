export function login({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.post('logi/',
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

export function register({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.post('register/',
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

