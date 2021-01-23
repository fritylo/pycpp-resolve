const currId = new URLSearchParams(window.location.search).get('id');
const URL = {
   _base: new URLSearchParams(location.search),
   set(key, value) {
      this._base.set(key, value);
      window.location = '?' + this._base.toString();
   },
   get(key) {
      return this._base.get(key);
   },
   has(key) {
      return this._base.has(key);
   }
};