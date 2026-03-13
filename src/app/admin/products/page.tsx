"use client";
import React, { useState, useEffect } from 'react';
import { 
  Search, 
  Plus, 
  Edit2, 
  Check, 
  XCircle, 
  Trash2, 
  ChevronDown
} from 'lucide-react';
import AdminSidebar from '@/components/AdminSidebar';
import { useRouter } from 'next/navigation';

export default function AdminProductsPage() {
  const router = useRouter();
  const [products, setProducts] = useState<any[]>([]);
  const [filteredProducts, setFilteredProducts] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  // Filters State
  const [search, setSearch] = useState('');
  const [category, setCategory] = useState('All Categories');
  const [status, setStatus] = useState('All Status');
  const [sortBy, setSortBy] = useState('Sort by');
  const [sortOrder, setSortOrder] = useState('Ascending');

  // Load Products
  const fetchProducts = async () => {
    try {
      setLoading(true);
      const res = await fetch('/api/products');
      const data = await res.json();
      setProducts(data);
      setFilteredProducts(data);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);


  // Handle Filtering and Sorting automatically via useEffect
  useEffect(() => {
    let result = [...products];

    // 1. Search Filter
    if (search.trim()) {
      result = result.filter(p => p.name.toLowerCase().includes(search.toLowerCase()) || (p.description && p.description.toLowerCase().includes(search.toLowerCase())));
    }

    // 2. Category Filter
    if (category !== 'All Categories') {
      result = result.filter(p => p.category === category);
    }

    // 3. Status Filter (assuming available/sold out)
    if (status !== 'All Status') {
      result = result.filter(p => p.status.toLowerCase() === status.toLowerCase());
    }

    // 4. Sorting
    result.sort((a, b) => {
      let sortKey = sortBy === 'Sort by' ? 'name' : sortBy.toLowerCase();
      let valA = a[sortKey] || '';
      let valB = b[sortKey] || '';
      
      if (sortKey === 'price') {
         valA = Number(valA);
         valB = Number(valB);
      }

      if (valA < valB) return sortOrder === 'Ascending' ? -1 : 1;
      if (valA > valB) return sortOrder === 'Ascending' ? 1 : -1;
      return 0;
    });

    setFilteredProducts(result);
  }, [search, category, status, sortBy, sortOrder, products]);

  // Reset Filters
  const resetFilters = () => {
    setSearch('');
    setCategory('All Categories');
    setStatus('All Status');
    setSortBy('Sort by');
    setSortOrder('Ascending');
    setFilteredProducts(products);
  };

  // Actions
  const toggleStatus = async (id: number, currentStatus: string) => {
    const newStatus = currentStatus === 'available' ? 'sold out' : 'available';
    try {
      const res = await fetch(`/api/products/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status: newStatus })
      });
      if (res.ok) {
        fetchProducts(); // refresh
      }
    } catch (err) {
      console.error('Failed to update status', err);
    }
  };

  const deleteProduct = async (id: number) => {
    if (!window.confirm("Are you sure you want to delete this product?")) return;
    
    try {
      const res = await fetch(`/api/products/${id}`, { method: 'DELETE' });
      if (res.ok) {
        fetchProducts(); // refresh
      }
    } catch (err) {
      console.error('Failed to delete', err);
    }
  };

  // Extract unique categories for dropdown
  const uniqueCategories = ['All Categories', ...Array.from(new Set(products.map(p => p.category)))];

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      
      <main className="flex-grow md:pl-64 p-4 md:p-8 w-full">
        {/* Top Header */}
        <div className="flex justify-between items-center mb-8">
          <h1 className="text-xl font-bold text-coffee-950">Dashboard</h1>
          <div className="flex items-center space-x-4">
             <span className="text-sm text-coffee-400 font-medium">{new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric'})}</span>
             <div className="w-10 h-10 bg-coffee-100 rounded-lg flex items-center justify-center font-bold text-coffee-600">A</div>
          </div>
        </div>

        {/* Product Management Card */}
        <div className="bg-white rounded-[2rem] p-4 md:p-8 shadow-sm border border-coffee-50 overflow-hidden">
          <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <h2 className="text-2xl font-black text-coffee-950">Product Management</h2>
            <button 
              onClick={() => router.push('/admin/products/new')}
              className="bg-[#E4C1A1] text-white px-6 py-3 rounded-xl font-bold flex items-center space-x-2 hover:bg-[#d6af8c] transition-all shadow-md w-full md:w-auto justify-center"
            >
              <Plus className="h-5 w-5" />
              <span>Add Product</span>
            </button>
          </div>

          {/* Filters Bar */}
          <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4 mb-8">
            <div className="col-span-1 sm:col-span-2 md:col-span-1 relative">
              <Search className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300" />
              <input 
                type="text" 
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder="Search product..." 
                className="w-full bg-cream-50/50 border border-coffee-100 rounded-xl py-3 pl-10 pr-4 text-sm outline-none focus:ring-2 focus:ring-coffee-100" 
              />
            </div>
            
            <div className="relative group">
               <select 
                 value={category}
                 onChange={(e) => setCategory(e.target.value)}
                 className="w-full appearance-none bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 text-sm text-coffee-600 outline-none cursor-pointer"
               >
                 {uniqueCategories.map(cat => (
                   <option key={cat} value={cat}>{cat}</option>
                 ))}
               </select>
               <ChevronDown className="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300 pointer-events-none" />
            </div>

            <div className="relative group">
               <select 
                 value={status}
                 onChange={(e) => setStatus(e.target.value)}
                 className="w-full appearance-none bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 text-sm text-coffee-600 outline-none cursor-pointer"
               >
                 <option value="All Status">All Status</option>
                 <option value="Available">Available</option>
                 <option value="Sold Out">Sold Out</option>
               </select>
               <ChevronDown className="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300 pointer-events-none" />
            </div>

            <div className="relative group">
               <select 
                 value={sortBy}
                 onChange={(e) => setSortBy(e.target.value)}
                 className="w-full appearance-none bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 text-sm text-coffee-600 outline-none cursor-pointer"
               >
                 <option value="Sort by">Sort by</option>
                 <option value="Price">Price</option>
                 <option value="Name">Name</option>
               </select>
               <ChevronDown className="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300 pointer-events-none" />
            </div>

            <div className="relative group">
               <select 
                 value={sortOrder}
                 onChange={(e) => setSortOrder(e.target.value)}
                 className="w-full appearance-none bg-cream-50/50 border border-coffee-100 rounded-xl py-3 px-4 text-sm text-coffee-600 outline-none cursor-pointer"
               >
                 <option value="Ascending">Ascending</option>
                 <option value="Descending">Descending</option>
               </select>
               <ChevronDown className="absolute right-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-300 pointer-events-none" />
            </div>

            <div className="flex space-x-2 sm:col-span-2 md:col-span-1">
              <button onClick={resetFilters} className="w-full bg-cream-100 text-coffee-600 rounded-xl font-bold py-3 hover:bg-cream-200 transition-all">Reset Filters</button>
            </div>
          </div>

          {/* Products Table */}
          <div className="overflow-x-auto">
            <table className="w-full text-left min-w-[800px]">
              <thead>
                <tr className="border-b border-coffee-50 text-coffee-300 text-xs font-black uppercase tracking-widest">
                  <th className="pb-4 pt-2 px-2">#</th>
                  <th className="pb-4 pt-2">Name</th>
                  <th className="pb-4 pt-2">Description</th>
                  <th className="pb-4 pt-2 text-right">Price</th>
                  <th className="pb-4 pt-2 pl-4">Category</th>
                  <th className="pb-4 pt-2 text-center">Status</th>
                  <th className="pb-4 pt-2 text-center">Actions</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-coffee-50">
                {loading ? (
                  <tr>
                    <td colSpan={7} className="text-center py-10 text-coffee-400">Loading products...</td>
                  </tr>
                ) : filteredProducts.length === 0 ? (
                  <tr>
                    <td colSpan={7} className="text-center py-10 text-coffee-400">No products found.</td>
                  </tr>
                ) : (
                  filteredProducts.map((product, idx) => (
                    <tr key={product.id} className="group hover:bg-cream-50/30 transition-colors">
                      <td className="py-5 px-2 text-sm font-bold text-coffee-400">{idx + 1}</td>
                      <td className="py-5 text-sm font-bold text-coffee-950 flex items-center space-x-3">
                        <div className="w-10 h-10 rounded-lg overflow-hidden bg-cream-50 flex-shrink-0">
                          <img src={product.name.toLowerCase().includes('banana bread') ? '/images/bananabread.jpg' : (product.image || '/images/default.png')} alt={product.name} className="w-full h-full object-cover" />
                        </div>
                        <span className="truncate max-w-[150px]">{product.name}</span>
                      </td>
                      <td className="py-5 text-xs text-coffee-400 max-w-[150px] truncate pr-4">{product.description || 'No description'}</td>
                      <td className="py-5 text-sm font-black text-coffee-950 text-right">₱{Number(product.price).toFixed(2)}</td>
                      <td className="py-5 text-sm font-medium text-coffee-600 pl-4">{product.category}</td>
                      <td className="py-5 text-center">
                        <span className={`px-3 py-1 rounded-lg text-xs font-bold uppercase ${
                          product.status === 'available' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'
                        }`}>
                          {product.status || 'Available'}
                        </span>
                      </td>
                      <td className="py-5">
                        <div className="flex items-center justify-center space-x-2">
                          <button 
                            title="Edit Product"
                            onClick={() => router.push(`/admin/products/${product.id}/edit`)}
                            className="p-2 bg-amber-400 text-white rounded-lg hover:bg-amber-500 transition-all shadow-sm"
                          >
                            <Edit2 className="h-4 w-4" />
                          </button>
                          
                          <button 
                            title={product.status === 'available' ? 'Mark as Sold Out' : 'Mark as Available'}
                            onClick={() => toggleStatus(product.id, product.status || 'available')}
                            className={`p-2 text-white rounded-lg transition-all shadow-sm ${
                              product.status === 'available' ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-gray-400 hover:bg-gray-500'
                            }`}
                          >
                            {product.status === 'available' ? <Check className="h-4 w-4" /> : <XCircle className="h-4 w-4" />}
                          </button>
                          
                          <button 
                            title="Delete Product"
                            onClick={() => deleteProduct(product.id)}
                            className="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all shadow-sm"
                          >
                            <Trash2 className="h-4 w-4" />
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))
                )}
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  );
}
