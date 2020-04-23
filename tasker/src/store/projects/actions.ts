export function createProject ({ commit }, payload) {
  return new Promise ((res, rej) => {
    this._vm.$axios.post('/projects',
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

export function getProjects({commit}, payload) {
  return new Promise((res, rej) => {
     this._vm.$axios.get('/projects',
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
export function deleteProject({commit}, payload) {
  return new Promise((res, rej) => {
    this._vm.$axios.delete('/projects/' + payload,
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
