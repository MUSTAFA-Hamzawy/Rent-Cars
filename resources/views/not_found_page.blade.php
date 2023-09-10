<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:300');
    body {
        background: #3498DB;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        font-size: 16px;
        display: flex; /* Use Flexbox to center content */
        align-items: center; /* Vertically center content */
        justify-content: center; /* Horizontally center content */
        height: 100vh; /* Make the body fill the viewport height */
        margin: 0; /* Remove default margin */
    }
    .container {
        text-align: center; /* Center-align the text within the container */
    }
    h1 {
        font-size: 30vh;
    }
    h2 span {
        font-size: 4rem;
        font-weight: 600;
    }
    a:link,
    a:visited {
        text-decoration: none;
        color: #fff;
    }
    h3 a:hover {
        text-decoration: none;
        background: #fff;
        color: #3498DB;
        cursor: pointer;
    }
</style>
<div class="container">
    <h1>:(</h1><br>
    <h2>Page not found, check the URL and try again.</h2><br><br>
    <h3><a href="{{ route('dashboard') }}">Return to home</a></h3>
</div>
