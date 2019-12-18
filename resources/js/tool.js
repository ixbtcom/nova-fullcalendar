Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'fullcalendar',
            path: '/fullcalendar',
            component: require('./components/Tool'),
        },
    ])
})
