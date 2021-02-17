<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script> -->
<script src="https://unpkg.com/ag-grid-enterprise/dist/ag-grid-enterprise.min.noStyle.js"></script>
<link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-grid.css">
<link rel="stylesheet" href="https://unpkg.com/ag-grid-community/dist/styles/ag-theme-alpine.css">
<style>

.sidenav {
  width: 130px;
  position: fixed;
  z-index: 1;
  top: 20px;
  left: 10px;
  background: #eee;
  overflow-x: hidden;
  padding: 8px 0;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #2196F3;
  display: block;
}

.main {
  margin-left: 140px; /* Same width as the sidebar + left position in px */
  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

</style>
</head>
<body>
<div class="sidenav">
  <a href="index.php">Sorting & Filtering</a>
  <a href="group.php">Grouping</a>
  <a href="pagination.php">Pagination & Export</a>
</div>

