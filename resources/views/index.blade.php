<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My first Vue app</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- Vue.js script -->
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <style>
        .ok {
            font-size: 24pt;
            color: blue;
            padding: 5px 10px;
            border: 2px solid red;
        }
        .ng {
            font-size: 20pt;
            color: gray;
        }
    </style>
    <h1 class="bg-secondary text-white display-4 px-3">Vue</h1>
    <div id="app" class="container">
        <p v-if="flag" class="ok">
            @{{ message }}
        </p>
        <p v-else class="ng">
            *現在、問題が発生中です・・・・
        </p>
    </div>

    <script>
        const appdata = {
            data() {
                return {
                    message: 'This. ',
                    flag: true
                }
            },
            mounted() {
                setInterval(() => {
                    this.flag = !this.flag
                }, 10000);
            }
        },

        let app = Vue.createApp(appdata)
        app.mount('#app')
    </script>
</body>
</html>
