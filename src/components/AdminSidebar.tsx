"use client";
import Link from 'next/link';
import { usePathname, useRouter } from 'next/navigation';
import { 
  LayoutGrid, 
  Package, 
  ClipboardList, 
  Tags, 
  Users, 
  Eye, 
  LogOut 
} from 'lucide-react';

export default function AdminSidebar() {
  const pathname = usePathname();
  const router = useRouter();

  const handleLogout = () => {
    localStorage.removeItem('user_role');
    router.push('/admin/login');
  };

  const menuItems = [
    { title: 'Dashboard', icon: LayoutGrid, href: '/admin' },
    { title: 'Products', icon: Package, href: '/admin/products' },
    { title: 'Orders', icon: ClipboardList, href: '/admin/orders' },
    { title: 'Categories', icon: Tags, href: '/admin/categories' },
    { title: 'Users', icon: Users, href: '/admin/users' },
  ];

  return (
    <>
      <div className="hidden md:flex w-64 bg-[#2D1B14] text-white min-h-screen p-6 flex-col fixed left-0 top-0 shadow-xl z-50">
        {/* Logo Section */}
        <div className="flex flex-col items-center mb-10 mt-4">
          <div className="w-36 h-36 flex items-center justify-center overflow-hidden p-1">
             <img src="/images/logo.png" alt="NextCafe Logo" className="w-full h-auto drop-shadow-2xl" />
          </div>
        </div>

        {/* Navigation */}
        <nav className="flex-grow space-y-1">
          {menuItems.map((item) => {
            const isActive = pathname === item.href;
            return (
              <Link 
                key={item.title}
                href={item.href}
                className={`flex items-center space-x-3 p-3.5 rounded-xl transition-all font-medium group ${
                  isActive 
                  ? 'bg-[#C69276] text-white shadow-lg' 
                  : 'text-cream-100/50 hover:bg-white/5 hover:text-white'
                }`}
              >
                <item.icon className={`h-5 w-5 ${isActive ? 'text-white' : 'text-cream-100/30'}`} />
                <span className="text-sm">{item.title}</span>
              </Link>
            );
          })}
        </nav>

        {/* Footer Actions */}
        <div className="pt-6 border-t border-white/5 space-y-2">
          <Link href="/" className="flex items-center space-x-3 p-3.5 rounded-xl text-cream-100/50 hover:bg-white/5 hover:text-white transition-all">
            <Eye className="h-5 w-5" />
            <span className="text-sm">View Shop</span>
          </Link>
          <button 
            onClick={handleLogout}
            className="w-full flex items-center space-x-3 p-3.5 rounded-xl text-red-300 hover:bg-red-500/10 transition-all font-bold mt-2"
          >
            <LogOut className="h-5 w-5" />
            <span className="text-sm">Logout</span>
          </button>
        </div>
      </div>

      {/* Mobile Bottom Navigation */}
      <div className="md:hidden fixed bottom-0 left-0 right-0 bg-[#2D1B14] border-t border-white/10 shadow-2xl z-50 flex justify-around items-center px-1 py-3 pb-safe-bottom">
        {menuItems.slice(0, 4).map((item) => {
          const isActive = pathname === item.href;
          return (
            <Link 
              key={item.title}
              href={item.href}
              className={`flex flex-col items-center p-2 rounded-xl transition-all ${
                isActive ? 'text-[#C69276]' : 'text-cream-100/50 hover:text-white'
              }`}
            >
              <item.icon className="h-5 w-5 mb-1" />
              <span className="text-[10px] font-medium text-center">{item.title}</span>
            </Link>
          );
        })}
        <button 
          onClick={handleLogout}
          className="flex flex-col items-center p-2 rounded-xl text-red-400 hover:text-red-300 transition-all"
        >
          <LogOut className="h-5 w-5 mb-1" />
          <span className="text-[10px] font-medium text-center">Logout</span>
        </button>
      </div>
    </>
  );
}
