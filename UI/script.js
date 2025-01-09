fetch('http://127.0.0.1:8000/api/cars')
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json(); // Parse the JSON data
  })
  .then(data => {
    console.log(data); // Handle the fetched data
  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });