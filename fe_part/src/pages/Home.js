import React, { useEffect, useState } from 'react';
import api from '../api';
import { useNavigate } from 'react-router-dom';
import '../style/Home.css';
//import axios from 'axios';


const Home = () => {
  const [products, setProducts] = useState([]);
  const [search, setSearch] = useState('');

  useEffect(() => {
    const fetchProducts = async () => {
        const response = await api.get('/PagingProduct', {
          params: { search_bar: search }
        });
        setProducts(response.data.products);
    };
    fetchProducts();
  }, [search]);
  const navigate = useNavigate();

  const handle_delete = async (productId) => {
    setProducts(products.filter(product => product.id !== productId));
    let end = '/product/' + productId;
    await api.delete(end);
    navigate('/');
  };

  const handleSearch = (event) => {
    setSearch(event.target.value);
  };
  const handleEdit = (productId) => {
    let end = '/Edit/' + productId;
    navigate(end);
  };

  return (
    <div>
      <label>Search:</label>
      <input type="text" value={search} onChange={handleSearch} /><br /><br />
      <a href="/AddProduct">Add New Item</a>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>User</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {products.map(product => (
            <tr key={product.id}>
              <td>{product.id}</td>
              <td>{product.pname}</td>
              <td>{product.Price}</td>
              <td>{product.des}</td>
              <td>{product.uid}</td>
              <td>
                <button onClick={() => handleEdit(product.id)}>Edit</button>
                <button onClick={() => handle_delete(product.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Home;
