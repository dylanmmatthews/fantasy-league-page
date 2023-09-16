<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-900 dark:text-white">
    @livewire('navigation')
    <livewire:stats-table/>
    @livewireScripts
</body>

</html>
