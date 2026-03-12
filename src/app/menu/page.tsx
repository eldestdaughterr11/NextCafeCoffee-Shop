"use client";
import React, { useState, useEffect } from 'react';
import { Search, Coffee, Cookie, CupSoda, LayoutGrid, Loader2 } from 'lucide-react';
import ProductCard from '@/components/ProductCard';
import { motion, AnimatePresence } from 'framer-motion';

// Blueprint para sa Product
interface Product {
  id: number;
  name: string;
  description: string;
  price: number | string;
  image: string;
  category: string;
}

export default function MenuPage() {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [filter, setFilter] = useState('all');
  const [search, setSearch] = useState('');

  useEffect(() => {
    async function fetchProducts() {
      try {
        setLoading(true);
        const res = await fetch(`/api/products?category=${filter === 'all' ? '' : filter}`);
        if (!res.ok) throw new Error('API Error');
        const data = await res.json();
        
        // Safety: Siguraduhing laging array ang data
        setProducts(Array.isArray(data) ? data : []);
      } catch (error) {
        console.error("Failed to fetch products", error);
        setProducts([]); // Fallback sa empty array para hindi mag-crash
      } finally {
        setLoading(false);
      }
    }
    fetchProducts();
  }, [filter]);

  const filteredProducts = products.filter(p => 
    p.name?.toLowerCase().includes(search.toLowerCase())
  );

  const categories = [
    { id: 'all', label: 'All Items', icon: LayoutGrid },
    { id: 'Cold Brew', label: 'Coffee', icon: Coffee },
    { id: 'Milk Based', label: 'Cappuccino', icon: Coffee },
    { id: 'Pastries', label: 'Pastries', icon: Cookie },
    { id: 'Frappe', label: 'Frappes', icon: CupSoda },
  ];

  return (
    <div className="max-w-7xl mx-auto min-h-screen">
      {/* Header */}
      <div className="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-8">
        <div>
          <h1 className="text-5xl font-black text-coffee-950 mb-4 tracking-tight">Our Menu</h1>
          <p className="text-coffee-600 font-medium uppercase tracking-[0.2em] text-sm italic">
            Carefully Crafted Coffee & Treats
          </p>
        </div>

        <div className="relative group w-full md:w-96">
          <Search className="absolute left-5 top-1/2 -translate-y-1/2 text-coffee-300 h-5 w-5" />
          <input 
            type="text" 
            placeholder="Search your favorite..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="w-full bg-white border border-coffee-100 rounded-2xl py-4 pl-14 pr-6 outline-none focus:ring-4 focus:ring-coffee-100/20 transition-all shadow-sm"
          />
        </div>
      </div>

      {/* Categories */}
      <div className="flex flex-wrap gap-4 mb-12">
        {categories.map((cat) => (
          <button
            key={cat.id}
            onClick={() => setFilter(cat.id)}
            className={`flex items-center space-x-3 px-8 py-4 rounded-2xl font-bold transition-all ${
              filter === cat.id 
              ? 'bg-[#C69276] text-white shadow-xl shadow-[#C69276]/20 scale-105' 
              : 'bg-white text-coffee-600 hover:bg-coffee-50 border border-coffee-50'
            }`}
          >
            <cat.icon className="h-5 w-5" />
            <span>{cat.label}</span>
          </button>
        ))}
      </div>

      {/* Main Grid */}
      {loading ? (
        <div className="flex flex-col items-center justify-center py-32 space-y-4">
          <Loader2 className="h-12 w-12 text-[#C69276] animate-spin" />
          <p className="text-coffee-400 font-bold animate-pulse">Brewing your menu...</p>
        </div>
      ) : (
        <AnimatePresence mode="wait">
          {filteredProducts.length > 0 ? (
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
            >
              {filteredProducts.map((product) => (
                <ProductCard key={product.id} product={product} />
              ))}
            </motion.div>
          ) : (
            <div className="py-32 text-center bg-white rounded-[3rem] border border-dashed border-coffee-100">
               <Coffee className="h-16 w-16 text-coffee-100 mx-auto mb-6" />
               <h2 className="text-2xl font-bold text-coffee-950">No items available yet</h2>
               <p className="text-coffee-500">Check back later or try a different category.</p>
            </div>
          )}
        </AnimatePresence>
      )}
    </div>
  );
}
