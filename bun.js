import Laravel from './.nuxt';

Bun.serve({
  port: 8000,
  fetch: (request) => {
    return Laravel.handle(request);
  },
});