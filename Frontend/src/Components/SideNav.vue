<template>
  <div class="sidebar" role="navigation" aria-label="Main Navigation">
 
    <nav>
      <ul>
        <li><router-link to="/" active-class="active-link" exact>Dashboard</router-link></li>
        <li><router-link to="/policies" active-class="active-link">Policies Table</router-link></li>
        <li><router-link to="/charts" active-class="active-link">Analytics</router-link></li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  name: "SideNav",
};
</script>

<style scoped>
.sidebar {
  width: 220px;
  height: 100vh;
  background-color: #1e293b;
  color: white;
  padding: 20px;
  box-sizing: border-box;
  position: fixed;
  left: 0;
  top: 0;
}

.sidebar h2 {
  font-size: 20px;
  margin-bottom: 20px;
  border-bottom: 1px solid #334155;
  padding-bottom: 10px;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar li {
  margin: 12px 0;
}

.sidebar a {
  color: white;
  text-decoration: none;
  padding: 8px 12px;
  display: block;
  border-radius: 4px;
  outline-offset: 2px;
}

.sidebar a:hover,
.sidebar a:focus,
.sidebar a.active-link {
  background-color: #334155;
  outline: none;
}

.sidebar a:focus-visible {
  outline: 2px solid #60a5fa; 
}
</style>
