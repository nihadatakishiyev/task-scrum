export function login ({ commit }, payload) {
  return new Promise ((res, rej) => {
      try {
        res(payload)
      }catch (e) {
        rej(e)
      }
  })
}
export function register ({ commit }, payload) {
  return new Promise ((res, rej) => {
    try {
      res(payload)
    }catch (e) {
      rej(e)
    }
  })
}

