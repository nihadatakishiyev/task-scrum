export function login({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.post('/login',
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
    this._vm.$axios.post('/register',
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

export function isLogged({commit}, payload) {
  return new Promise((res, rej) => {
    try {
      res(payload)
    } catch (e) {
      rej(e)
    }
  })
}
