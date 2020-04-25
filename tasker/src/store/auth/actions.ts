export function login({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.post('/login',
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(error => {
        if(error.response.status === 401) {
          this._vm.$q.notify({
            message: error.response.data.message,
            color: 'orange',
            icon: 'error',
            position: 'top'
          })
        }
        rej(error.response)
      })
  })
}
export function errorConvert(errors) {
  // const error
  var result = Object.keys(errors).map(function(key) {
    return [Number(key), errors[key]];
  });
  console.log(result.map(error => error[0]).join(' '))

  // let errorsTest = errors.map(a => a[0] )
  // this.$q.notify({
  //   message: errorsTest.join('\n'),
  //   color: 'orange',
  //   icon: 'error',
  //   position: 'top'
  // })

}
export function register({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.post('/register',
      payload
    )
      .then(function (response) {
        res(response)
      })
      .catch(error=>{
        errorConvert(error)
        if(error.response.status === 422){
          this._vm.$q.notify({
            message: error.response.data.message,
            color: 'orange',
            icon: 'error',
            position: 'top'
          })
          console.log(error.response.data.message)
        }
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
