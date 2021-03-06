module.exports = {
    future: {
        // removeDeprecatedGapUtilities: true,
        // purgeLayersByDefault: true,
    },
    purge: [],
    theme: {
        extend: {
            colors: {
                arwad: {
                    '500': '#AE9F51',
                },
            },
            inset: {
                '12': '3rem'
            },
            spacing: {
                '70': '20rem',
            }
        },
    },
    variants: {},
    plugins: [
        require('@tailwindcss/ui')
    ],
}
