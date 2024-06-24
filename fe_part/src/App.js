import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Home from './pages/Home';
import Add from './pages/Add';
import Edit from './pages/Edit';

const App = () => {
  return (
    <Router>
      <h1>Items</h1>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/AddProduct" element={<Add />} />
        <Route path="/Edit/:id" element={<Edit/>} />
      </Routes>
    </Router>
  );
};

export default App;
