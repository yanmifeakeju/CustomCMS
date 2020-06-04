<footer class="footer mt-5 p-3 text-center bg-light" id="sticky-footer">
  CustomCMS &copy; <?=date('Y')?>
</footer>
</body>
<script>
  document.addEventListener('DOMContentLoaded', () => {

    const rows = document.querySelectorAll('tr[data-href]');
    rows.forEach(row => {
      row.addEventListener('click', (e) => {

        if (e.target.classList.contains('publish')) {
          const id = e.target.parentElement.id;
          const data = new FormData;
          data.append('id', id);
          fetch('/admin/publish.php', {
            method: 'POST',
            body: data
          }).then(response => response.text()).then(data => {
            e.target.parentElement.innerText = data;
          })
          .catch(error => console.log(error));
        } else {
          window.location.href = row.dataset.href;
        }

      })
    })
  });

  // async function post(url, data) {
  //   const response = await fetch(url, {
  //     method: 'POST',
  //     headers: {
  //       'Content-type': 'application/json'
  //     },
  //     body: JSON.stringify(data)
  //   });

  //   const resData = await response.json();
  //   return resData;
  // }
</script>

</html>