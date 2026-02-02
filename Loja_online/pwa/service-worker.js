self.addEventListener("install", e => {
  e.waitUntil(
    caches.open("loja-cache").then(cache => {
      return cache.addAll([
        "/assets/css/style.css",
        "/public/index.php"
      ]);
    })
  );
});
