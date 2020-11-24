Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'module-usage',
      path: '/module-usage',
      component: require('./components/Tool'),
    },
  ])
})
