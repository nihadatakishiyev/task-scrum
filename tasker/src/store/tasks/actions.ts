export function createTast({commit}, payload) {
  return new Promise((res, rej) => {
    try {
      res(payload)
    } catch (e) {
      rej(e)
    }
  })
}
