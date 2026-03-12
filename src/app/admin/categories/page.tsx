"use client";
import React, { useState, useEffect } from 'react';
import AdminSidebar from '@/components/AdminSidebar';
import { Tags, Loader2, Coffee, Plus } from 'lucide-react';

import { useRouter } from 'next/navigation';

export default function AdminCategoriesPage() {
  const router = useRouter();
  const [categories, setCategories] = useState<any[]>([]);
  const [loading, setLoading] = useState(true);

  const fetchCategories = async () => {
    try {
      const res = await fetch('/api/products');
      if (res.ok) {
        const products = await res.json();
        const uniqueCats = Array.from(new Set(products.map((p: any) => p.category))).filter(Boolean);
        
        const catData = uniqueCats.map((catName) => {
          const count = products.filter((p: any) => p.category === catName).length;
          return { name: catName, count };
        });

        setCategories(catData);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchCategories();
  }, []);

  const handleEditCategory = async (oldName: string) => {
    const newName = window.prompt(`Rename category "${oldName}" to:`, oldName);
    if (!newName || newName === oldName) return;

    try {
      setLoading(true);
      const res = await fetch('/api/admin/categories', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ oldName, newName })
      });

      if (res.ok) {
        fetchCategories(); // Refresh data
      } else {
        alert("Failed to rename category");
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const handleAddCategory = () => {
    const newName = window.prompt("Enter new category name:");
    if (newName) {
       // Open Add Product page with the pre-filled category URL param (requires handling in the new product page if implemented later, or just simple redirect)
       router.push(`/admin/products/new?category=${encodeURIComponent(newName)}`);
    }
  };

  return (
    <div className="flex min-h-screen bg-[#FDF8F3]">
      <AdminSidebar />
      <main className="flex-grow md:pl-64 p-4 md:p-8">
        <div className="flex justify-between items-center mb-10">
          <h1 className="text-3xl font-black text-coffee-950">Categories Management</h1>
          <button onClick={handleAddCategory} className="bg-[#E4C1A1] text-white px-6 py-3 rounded-xl font-bold flex items-center space-x-2 hover:bg-[#d6af8c] transition-all shadow-md">
            <Plus className="h-4 w-4" />
            <span>Add Category</span>
          </button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {loading ? (
             <div className="col-span-full flex justify-center items-center py-20">
               <Loader2 className="h-10 w-10 text-coffee-300 animate-spin" />
             </div>
          ) : categories.length === 0 ? (
             <p className="col-span-full text-center text-coffee-400 py-10 font-bold uppercase tracking-widest text-xs">No categories found.</p>
          ) : (
            categories.map((cat, idx) => (
               <div key={idx} className="bg-white p-8 rounded-[2rem] border border-coffee-50 shadow-sm hover:shadow-lg transition-all group">
                 <div className="w-16 h-16 bg-cream-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#C69276] transition-colors">
                    <Coffee className="h-8 w-8 text-[#C69276] group-hover:text-white transition-colors" />
                 </div>
                 <h2 className="text-2xl font-black text-coffee-950 mb-2">{String(cat.name)}</h2>
                 <p className="text-coffee-400 font-bold uppercase tracking-widest text-xs">
                    {cat.count} Products Available
                 </p>

                 <div className="flex space-x-2 mt-8">
                    <button onClick={() => handleEditCategory(cat.name)} className="flex-grow text-xs font-black uppercase tracking-widest bg-cream-50 text-coffee-600 py-3 rounded-xl hover:bg-coffee-100 transition-colors">
                      Edit
                    </button>
                 </div>
               </div>
            ))
          )}

          {/* Dummy visual card for new  */}
          {!loading && (
             <div onClick={handleAddCategory} className="bg-cream-50/50 p-8 rounded-[2rem] border-2 border-dashed border-coffee-100 flex flex-col items-center justify-center min-h-[250px] cursor-pointer hover:bg-cream-100 transition-colors">
                 <div className="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-4 text-coffee-300 shadow-sm">
                    <Plus className="h-8 w-8" />
                 </div>
                 <h2 className="text-lg font-black text-coffee-400">Add New Category</h2>
             </div>
          )}
        </div>
      </main>
    </div>
  );
}
