var option = {
    rev: "staging",
    maps: false
};

module.exports = {
    bundle: {
        "css/main": {
            styles: [
                'app/css/*.css'
            ],
            options: option
        },
        "js/common": {
            scripts: [
                'app/js/*.js'
            ],
            options: option
        },
        "css/vendor": {
            styles: [
                'app/libs/bootstrap/css/bootstrap.min.css',
                'app/libs/normalize.css/normalize.css',
                'app/libs/select2/css/select2.min.css',
                'app/libs/daterangepicker/daterangepicker.css',
            ],
            options: option
        },
        "js/vendor": {
            scripts: [
                'app/libs/jquery/jquery.min.js',
                'app/libs/bootstrap/js/bootstrap.bundle.min.js',
                'app/libs/imagesloaded/imagesloaded.pkgd.min.js',
                'app/libs/jquery.easing/jquery.easing.min.js',
                'app/libs/jquery.scrollto/jquery.scrollTo.min.js',
                'app/libs/select2/js/select2.full.min.js',
                'app/libs/parsleyjs/parsley.min.js',
                'app/libs/daterangepicker/moment.min.js',
                'app/libs/daterangepicker/daterangepicker.js'
            ],
            options: option
        },
    },
    copy: [
        {
            src: 'app/*.php',
            base: 'app'
        },
        {
            src: 'app/include/**/*.php',
            base: 'app'
        },
        {
            src: 'app/*.txt',
            base: 'app'
        },
        {
            src: 'app/**/*.{jpg,png,gif,jpeg}',
            base: 'app'
        }
    ]
};