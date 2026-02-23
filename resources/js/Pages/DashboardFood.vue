<template>
    <div>
        <h1>Dashboard</h1>
        <p>Welcome to the dashboard! This is a protected page.</p>
        <div class="btn">
            <button class="button1" @click="auth.logout">Logout</button>
            </div>
            <div class="btn">
            <router-link to="/users">
                <button class="button2">Users</button>
            </router-link>
            </div>
    </div>
</template>